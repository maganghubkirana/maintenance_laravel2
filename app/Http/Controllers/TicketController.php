<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\MaintenanceLog;
use App\Models\MaintenanceTicket;
use App\Models\TicketStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * Menampilkan daftar semua tiket maintenance.
     */
    public function index()
    {
        $tickets = MaintenanceTicket::with(['device', 'reporter', 'technician'])
            ->latest()
            ->paginate(10);

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Menampilkan form untuk membuat tiket baru.
     */
    public function create()
    {
        $devices = Device::where('status', '!=', 'retired')->get();
        return view('tickets.create', compact('devices'));
    }

    /**
     * Menyimpan tiket baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'device_id'   => 'required|exists:devices,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'priority'    => 'required|in:low,medium,high,urgent',
            'image_proof' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        DB::transaction(function () use ($request) {
            // Upload foto bukti jika ada
            $imagePath = null;
            if ($request->hasFile('image_proof')) {
                $imagePath = $request->file('image_proof')->store('tickets/proofs', 'public');
            }

            // Generate Nomor Tiket Otomatis (Contoh: TKT-20260902-8X9A)
            $ticketNumber = 'TKT-' . date('Ymd') . '-' . strtoupper(Str::random(4));

            // 1. Buat Tiket Maintenance
            $ticket = MaintenanceTicket::create([
                'ticket_number' => $ticketNumber,
                'device_id'     => $request->device_id,
                'reported_by'   => Auth::id(),
                'title'         => $request->title,
                'description'   => $request->description,
                'priority'      => $request->priority,
                'status'        => 'open',
                'image_proof'   => $imagePath,
            ]);

            // 2. Ubah status perangkat menjadi 'in_repair' atau 'damaged'
            Device::where('id', $request->device_id)->update(['status' => 'in_repair']);

            // 3. Catat riwayat status pertama kali
            TicketStatusHistory::create([
                'ticket_id'  => $ticket->id,
                'user_id'    => Auth::id(),
                'old_status' => null,
                'new_status' => 'open',
                'notes'      => 'Tiket pelaporan kerusakan berhasil dibuat.',
            ]);
        });

        return redirect()->route('tickets.index')->with('success', 'Tiket kerusakan berhasil dibuat!');
    }

    /**
     * Menampilkan detail tiket beserta riwayat perbaikan & status.
     */
    public function show($id)
    {
        $ticket = MaintenanceTicket::with([
            'device', 
            'reporter', 
            'technician', 
            'logs.technician', 
            'statusHistories.user'
        ])->findOrFail($id);

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Menugaskan/Assign teknisi ke tiket tertentu.
     */
    public function assignTechnician(Request $request, $id)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $ticket = MaintenanceTicket::findOrFail($id);
        $ticket->update(['assigned_to' => $request->assigned_to]);

        return redirect()->back()->with('success', 'Teknisi berhasil ditugaskan.');
    }

    /**
     * Mengubah status tiket dan mencatat riwayat perubahan.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,pending_sparepart,resolved,closed,cancelled',
            'notes'  => 'nullable|string',
        ]);

        $ticket = MaintenanceTicket::findOrFail($id);

        if ($ticket->status !== $request->status) {
            DB::transaction(function () use ($ticket, $request) {
                $oldStatus = $ticket->status;

                // Update status tiket
                $ticket->status = $request->status;
                if ($request->status === 'resolved') {
                    $ticket->resolved_at = now();
                }
                $ticket->save();

                // Jika status 'resolved' atau 'closed', kembalikan status perangkat menjadi 'active'
                if (in_array($request->status, ['resolved', 'closed'])) {
                    $ticket->device()->update(['status' => 'active']);
                }

                // Catat di tabel histori perubahan status
                TicketStatusHistory::create([
                    'ticket_id'  => $ticket->id,
                    'user_id'    => Auth::id(),
                    'old_status' => $oldStatus,
                    'new_status' => $request->status,
                    'notes'      => $request->notes,
                ]);
            });
        }

        return redirect()->back()->with('success', 'Status tiket berhasil diperbarui.');
    }

    /**
     * Menambahkan catatan tindakan/riwayat perbaikan oleh teknisi.
     */
    public function addLog(Request $request, $id)
    {
        $request->validate([
            'action_taken'     => 'required|string',
            'maintenance_type' => 'required|in:corrective,preventive',
            'cost'             => 'nullable|numeric|min:0',
        ]);

        MaintenanceLog::create([
            'ticket_id'        => $id,
            'technician_id'    => Auth::id(),
            'action_taken'     => $request->action_taken,
            'maintenance_type' => $request->maintenance_type,
            'cost'             => $request->cost ?? 0,
            'completed_at'     => now(),
        ]);

        return redirect()->back()->with('success', 'Log tindakan perbaikan berhasil ditambahkan.');
    }
}
