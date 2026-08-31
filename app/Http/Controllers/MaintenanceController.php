<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\MaintenanceRequest;
use App\Models\ApprovalHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $q = MaintenanceRequest::with('equipment','engineer')->latest();
        if (strtoupper(auth()->user()->role) === 'ENGINEER') $q->where('engineer_id', auth()->id());
        if ($request->filled('search')) $q->where(function($x) use ($request) { $s=$request->search; $x->where('id',$s)->orWhere('description','like',"%$s%")->orWhere('status','like',"%$s%")->orWhere('priority','like',"%$s%"); });
        $requests = $q->paginate(7)->withQueryString();
        $equipment = Equipment::where('status','<>','INACTIVE')->orderBy('name')->get();
        $engineers = \App\Models\User::whereRaw('UPPER(role)=?', ['ENGINEER'])->orderBy('username')->get();
        return view('maintenance.index', compact('requests','equipment','engineers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'equipment_id' => ['required','exists:equipment,id'],
            'engineer_id' => ['nullable','exists:users,id'],
            'priority' => ['required', Rule::in(['LOW','MEDIUM','HIGH','CRITICAL'])],
            'description' => ['required','string','max:5000'],
        ]);
        $data['engineer_id'] = $data['engineer_id'] ?: auth()->id();
        $data['status'] = 'PENDING_SUPERVISOR';
        $maintenance = MaintenanceRequest::create($data);
        return back()->with('success', "Maintenance #{$maintenance->id} berhasil dibuat dan dikirim ke Supervisor.");
    }

    public function updateStatus(Request $request, MaintenanceRequest $maintenance)
    {
        $user = auth()->user();
        $role = strtoupper($user->role);
        $target = strtoupper((string)$request->input('status'));
        $note = $request->input('note');
        $current = strtoupper($maintenance->status);

        $valid = match ($target) {
            'PENDING_MANAGER' => $role === 'SUPERVISOR' && $current === 'PENDING_SUPERVISOR',
            'APPROVED' => $role === 'MANAGER' && $current === 'PENDING_MANAGER',
            'REJECTED' => in_array($role,['SUPERVISOR','MANAGER'],true) && in_array($current,['PENDING_SUPERVISOR','PENDING_MANAGER'],true),
            'IN_PROGRESS' => $role === 'ENGINEER' && $current === 'APPROVED',
            'COMPLETED' => $role === 'ENGINEER' && $current === 'IN_PROGRESS',
            default => false,
        };
        abort_unless($valid, 422, "Transisi status {$current} → {$target} tidak diizinkan untuk role {$role}.");

        DB::transaction(function() use ($maintenance,$target,$user,$role,$note) {
            $previous = $maintenance->status;
            $maintenance->update(['status'=>$target]);
            ApprovalHistory::create([
                'maintenance_id'=>$maintenance->id,
                'user_id'=>$user->id,
                'role'=>$role,
                'action'=>$target === 'REJECTED' ? 'REJECT' : 'APPROVE',
                'note'=>$note,
                'created_at'=>now(),
            ]);
            if ($target === 'APPROVED') $maintenance->equipment()->update(['status'=>'MAINTENANCE']);
            if ($target === 'COMPLETED') $maintenance->equipment()->update(['status'=>'ACTIVE']);
        });
        return back()->with('success', "Maintenance #{$maintenance->id} berubah dari {$current} menjadi {$target}.");
    }

    public function history()
    {
        $history = MaintenanceRequest::with('equipment','engineer')->whereIn('status',['REJECTED','APPROVED','IN_PROGRESS','COMPLETED'])->latest()->paginate(10);
        return view('history.index', compact('history'));
    }
}
