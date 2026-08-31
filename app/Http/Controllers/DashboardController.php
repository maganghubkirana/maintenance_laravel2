<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\MaintenanceRequest;
use App\Models\ApprovalHistory;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $base = MaintenanceRequest::query();
        if (strtoupper($user->role) === 'ENGINEER') $base->where('engineer_id', $user->id);

        $stats = [
            'totalEquipment' => Equipment::count(),
            'activeMaintenance' => (clone $base)->whereIn('status', ['APPROVED','IN_PROGRESS'])->count(),
            'pendingApproval' => (clone $base)->whereIn('status', ['PENDING_SUPERVISOR','PENDING_MANAGER'])->count(),
            'completed' => (clone $base)->where('status','COMPLETED')->count(),
            'rejected' => (clone $base)->where('status','REJECTED')->count(),
            'totalMaintenance' => (clone $base)->count(),
        ];
        $stats['completionRate'] = $stats['totalMaintenance'] ? round($stats['completed'] / $stats['totalMaintenance'] * 100, 1) : 0;

        $trend = collect(range(1,12))->mapWithKeys(fn($m) => [$m => (clone $base)->whereMonth('created_at',$m)->whereYear('created_at',now()->year)->count()]);
        $status = (clone $base)->select('status', DB::raw('COUNT(*) total'))->groupBy('status')->orderBy('status')->get();
        $recent = (clone $base)->with('equipment','engineer')->latest()->limit(10)->get();
        $approvals = ApprovalHistory::with('user','maintenance.equipment')->latest('created_at')->limit(20)->get();

        return view('dashboard.index', compact('stats','trend','status','recent','approvals'));
    }
}
