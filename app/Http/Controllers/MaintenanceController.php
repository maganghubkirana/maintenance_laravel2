<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\MaintenanceRequest;
use App\Models\ApprovalHistory;
use App\Exports\MaintenanceHistoryExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;                    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MaintenanceController extends Controller
{
    /**
     * Menampilkan halaman Maintenance Request
     */
    public function index(Request $request)
    {
        $q = MaintenanceRequest::with('equipment', 'engineer')->latest();

        // Engineer hanya melihat maintenance miliknya
        if (strtoupper(auth()->user()->role) === 'ENGINEER') {
            $q->where('engineer_id', auth()->id());
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $q->where(function ($query) use ($search) {
                $query->where('id', $search)
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('priority', 'like', "%{$search}%");
            });
        }

        $requests = $q
            ->paginate(7)
            ->withQueryString();

        // Equipment aktif
        $equipment = Equipment::where('status', '<>', 'INACTIVE')
            ->orderBy('name')
            ->get();

        // Daftar engineer
        $engineers = \App\Models\User::whereRaw(
            'UPPER(role) = ?',
            ['ENGINEER']
        )
            ->orderBy('username')
            ->get();

        return view(
            'maintenance.index',
            compact('requests', 'equipment', 'engineers')
        );
    }

    /**
     * Membuat maintenance request
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'equipment_id' => [
                'required',
                'exists:equipment,id'
            ],

            'engineer_id' => [
                'nullable',
                'exists:users,id'
            ],

            'priority' => [
                'required',
                Rule::in([
                    'LOW',
                    'MEDIUM',
                    'HIGH',
                    'CRITICAL'
                ])
            ],

            'description' => [
                'required',
                'string',
                'max:5000'
            ],
        ]);

        // Kalau engineer tidak dipilih,
        // otomatis menggunakan user yang login
        $data['engineer_id'] = $data['engineer_id'] ?? auth()->id();

        // Status awal
        $data['status'] = 'PENDING_SUPERVISOR';

        $maintenance = MaintenanceRequest::create($data);

        return back()->with(
            'success',
            "Maintenance #{$maintenance->id} berhasil dibuat dan dikirim ke Supervisor."
        );
    }

    /**
     * Update status maintenance
     */
    public function updateStatus(
        Request $request,
        MaintenanceRequest $maintenance
    ) {
        $user = auth()->user();

        $role = strtoupper($user->role);
        $target = strtoupper((string) $request->input('status'));
        $note = $request->input('note');

        $current = strtoupper($maintenance->status);

        /*
        |--------------------------------------------------------------------------
        | Validasi alur approval
        |--------------------------------------------------------------------------
        */

        $valid = match ($target) {

            // Supervisor:
            // PENDING_SUPERVISOR -> PENDING_MANAGER
            'PENDING_MANAGER' =>
                $role === 'SUPERVISOR'
                && $current === 'PENDING_SUPERVISOR',

            // Manager:
            // PENDING_MANAGER -> APPROVED
            'APPROVED' =>
                $role === 'MANAGER'
                && $current === 'PENDING_MANAGER',

            // Supervisor / Manager bisa reject
            'REJECTED' =>
                in_array(
                    $role,
                    ['SUPERVISOR', 'MANAGER'],
                    true
                )
                &&
                in_array(
                    $current,
                    [
                        'PENDING_SUPERVISOR',
                        'PENDING_MANAGER'
                    ],
                    true
                ),

            // Engineer mulai mengerjakan
            'IN_PROGRESS' =>
                $role === 'ENGINEER'
                && $current === 'APPROVED',

            // Engineer menyelesaikan pekerjaan
            'COMPLETED' =>
                $role === 'ENGINEER'
                && $current === 'IN_PROGRESS',

            default => false,
        };

        abort_unless(
            $valid,
            422,
            "Transisi status {$current} → {$target} tidak diizinkan untuk role {$role}."
        );

        /*
        |--------------------------------------------------------------------------
        | Simpan perubahan
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $maintenance,
            $target,
            $user,
            $role,
            $note
        ) {

            // Update status
            $maintenance->update([
                'status' => $target
            ]);

            /*
            |--------------------------------------------------------------------------
            | Simpan approval history
            |--------------------------------------------------------------------------
            */

            ApprovalHistory::create([
                'maintenance_id' => $maintenance->id,
                'user_id' => $user->id,
                'role' => $role,
                'action' => $target === 'REJECTED'
                    ? 'REJECT'
                    : 'APPROVE',
                'note' => $note,
                'created_at' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Update status equipment
            |--------------------------------------------------------------------------
            */

            if ($target === 'APPROVED') {

                $maintenance
                    ->equipment()
                    ->update([
                        'status' => 'MAINTENANCE'
                    ]);
            }

            if ($target === 'COMPLETED') {

                $maintenance
                    ->equipment()
                    ->update([
                        'status' => 'ACTIVE'
                    ]);
            }
        });

        return back()->with(
            'success',
            "Maintenance #{$maintenance->id} berubah dari {$current} menjadi {$target}."
        );
    }

    /**
     * =========================================================================
     * HISTORY
     * =========================================================================
     */

    public function history(Request $request)
    {
        $query = MaintenanceRequest::with(
            'equipment',
            'engineer'
        )
            ->whereIn(
                'status',
                [
                    'REJECTED',
                    'APPROVED',
                    'IN_PROGRESS',
                    'COMPLETED'
                ]
            );

        /*
        |--------------------------------------------------------------------------
        | Filter tanggal mulai
        |--------------------------------------------------------------------------
        */

        if ($request->filled('start_date')) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->start_date
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter tanggal akhir
        |--------------------------------------------------------------------------
        */

        if ($request->filled('end_date')) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->end_date
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter status
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('status')
            && $request->status !== 'ALL'
        ) {

            $query->where(
                'status',
                strtoupper($request->status)
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $history = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'history.index',
            compact('history')
        );
    }

    /**
     * =========================================================================
     * EXPORT PDF
     * =========================================================================
     */

    public function exportPdf(Request $request)
    {
        $query = MaintenanceRequest::with(
            'equipment',
            'engineer'
        )
            ->whereIn(
                'status',
                [
                    'REJECTED',
                    'APPROVED',
                    'IN_PROGRESS',
                    'COMPLETED'
                ]
            );

        /*
        |--------------------------------------------------------------------------
        | Filter tanggal mulai
        |--------------------------------------------------------------------------
        */

        if ($request->filled('start_date')) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->start_date
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter tanggal akhir
        |--------------------------------------------------------------------------
        */

        if ($request->filled('end_date')) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->end_date
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter status
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('status')
            && $request->status !== 'ALL'
        ) {

            $query->where(
                'status',
                strtoupper($request->status)
            );
        }

        $history = $query
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Data informasi laporan
        |--------------------------------------------------------------------------
        */

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $status = $request->status ?? 'ALL';

        $pdf = Pdf::loadView(
            'reports.maintenance-history',
            compact(
                'history',
                'startDate',
                'endDate',
                'status'
            )
        );

        // Landscape A4
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download(
            'maintenance-history-' . now()->format('Y-m-d-His') . '.pdf'
        );
    }

    /**
     * =========================================================================
     * EXPORT EXCEL
     * =========================================================================
     */

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new MaintenanceHistoryExport(
                $request->start_date,
                $request->end_date,
                $request->status
            ),
            'maintenance-history-' . now()->format('Y-m-d-His') . '.xlsx'
        );
    }
}
