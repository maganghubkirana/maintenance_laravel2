<?php

// namespace App\Http\Controllers;

// use App\Models\Equipment;
// use App\Models\MaintenanceRequest;
// use App\Models\ApprovalHistory;
// use Illuminate\Support\Facades\DB;

// class DashboardController extends Controller
// {
//     public function index()
//     {
//         $user = auth()->user();
//         $base = MaintenanceRequest::query();
//         if (strtoupper($user->role) === 'ENGINEER') $base->where('engineer_id', $user->id);

//         $stats = [
//             'totalEquipment' => Equipment::count(),
//             'activeMaintenance' => (clone $base)->whereIn('status', ['APPROVED','IN_PROGRESS'])->count(),
//             'pendingApproval' => (clone $base)->whereIn('status', ['PENDING_SUPERVISOR','PENDING_MANAGER'])->count(),
//             'completed' => (clone $base)->where('status','COMPLETED')->count(),
//             'rejected' => (clone $base)->where('status','REJECTED')->count(),
//             'totalMaintenance' => (clone $base)->count(),
//         ];
//         $stats['completionRate'] = $stats['totalMaintenance'] ? round($stats['completed'] / $stats['totalMaintenance'] * 100, 1) : 0;

//         $trend = collect(range(1,12))->mapWithKeys(fn($m) => [$m => (clone $base)->whereMonth('created_at',$m)->whereYear('created_at',now()->year)->count()]);
//         $status = (clone $base)->select('status', DB::raw('COUNT(*) total'))->groupBy('status')->orderBy('status')->get();
//         $recent = (clone $base)->with('equipment','engineer')->latest()->limit(10)->get();
//         $approvals = ApprovalHistory::with('user','maintenance.equipment')->latest('created_at')->limit(20)->get();

//         return view('dashboard.index', compact('stats','trend','status','recent','approvals'));
//     }

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Equipment;
use App\Models\Sparepart;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = strtoupper($user->role);

        // Jika SUPERADMIN, langsung tampilkan layouts.app
       if ($role === 'SUPERADMIN') {
            return view('dashboard.superadmin', [
                'totalUsers'       => User::count(),
                'totalTickets'     => Ticket::count(),
                'totalEquipment'   => Equipment::count(),
                'totalSpareparts'  => Sparepart::count(),
                'recentTickets'    => Ticket::latest()->take(6)->get(),
            ]);
        }

        // Untuk role lainnya, tetap menggunakan view khusus di folder dashboard/
        switch (strtolower($role)) {
            case 'admin':
                return view('dashboard.admin', [
                    'totalTickets'       => Ticket::count(),
                    'pendingTickets'     => Ticket::where('status', 'pending')->count(),
                    'inProgressTickets'  => Ticket::where('status', 'in_progress')->count(),
                    'completedTickets'   => Ticket::where('status', 'completed')->count(),
                    'lowStockSpareparts' => Sparepart::whereColumn('stock', '<=', 'min_stock')->get(),
                ]);

            case 'engineer':
            case 'teknisi':
                return view('dashboard.engineer', [
                    'myTicketsCount'   => Ticket::where('assigned_to', $user->id)->count(),
                    'myPendingTickets' => Ticket::where('assigned_to', $user->id)->where('status', 'pending')->count(),
                    'myActiveTickets'  => Ticket::where('assigned_to', $user->id)->where('status', 'in_progress')->count(),
                    'myDoneTickets'    => Ticket::where('assigned_to', $user->id)->where('status', 'completed')->count(),
                    'myTickets'        => Ticket::where('assigned_to', $user->id)->latest()->take(6)->get(),
                ]);

            case 'supervisor':
                return view('dashboard.supervisor', [
                    'totalTickets'     => Ticket::count(),
                    'pendingTickets'   => Ticket::where('status', 'pending')->count(),
                    'inProgressTickets'=> Ticket::where('status', 'in_progress')->count(),
                    'completedTickets' => Ticket::where('status', 'completed')->count(),
                ]);

            case 'manager':
                $total = Ticket::count();
                $completed = Ticket::where('status', 'completed')->count();
                return view('dashboard.manager', [
                    'totalTickets'     => $total,
                    'completedTickets' => $completed,
                    'completionRate'   => $total > 0 ? round(($completed / $total) * 100) : 0,
                    'totalEquipment'   => Equipment::count(),
                    'totalSpareparts'  => Sparepart::count(),
                ]);

            default:
                return view('dashboard.user', [
                    'myReportedCount'  => Ticket::where('user_id', $user->id)->count(),
                    'myActiveCount'    => Ticket::where('user_id', $user->id)->where('status', 'in_progress')->count(),
                    'myCompletedCount' => Ticket::where('user_id', $user->id)->where('status', 'completed')->count(),
                ]);
        }
    }
}

