@extends('layouts.app') 

@section('title', 'History - Maintenance X') 
@section('page_title', 'History') 

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Maintenance History</h2>
            <p class="text-xs text-slate-500 mt-0.5">Riwayat seluruh request maintenance yang sudah diproses dalam sistem.</p>
        </div>
        <div class="flex items-center gap-2 text-xs text-slate-400 font-medium bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-200/60 self-start sm:self-auto">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Arsip Riwayat</span>
        </div>
    </div>

    <!-- Main Card & Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-xs text-slate-400 uppercase font-semibold border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-5">ID</th>
                        <th class="py-3.5 px-5">Equipment</th>
                        <th class="py-3.5 px-5">Engineer</th>
                        <th class="py-3.5 px-5">Priority</th>
                        <th class="py-3.5 px-5">Status</th>
                        <th class="py-3.5 px-5 max-w-xs">Description</th>
                        <th class="py-3.5 px-5">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($history as $r)
                        @php
                            // Styling dinamis untuk Priority
                            $pStyle = [
                                'LOW' => 'bg-slate-100 text-slate-700 border-slate-200',
                                'MEDIUM' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'HIGH' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'CRITICAL' => 'bg-red-50 text-red-700 border-red-200 font-bold',
                            ][strtoupper($r->priority)] ?? 'bg-slate-100 text-slate-700 border-slate-200';

                            // Styling dinamis untuk Status
                            $sStyle = [
                                'PENDING_SUPERVISOR' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'PENDING_MANAGER' => 'bg-purple-50 text-purple-700 border-purple-200',
                                'APPROVED' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'IN_PROGRESS' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                'COMPLETED' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'REJECTED' => 'bg-rose-50 text-rose-700 border-rose-200',
                            ][strtoupper($r->status)] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                        @endphp

                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-5 font-bold text-slate-900">#{{ $r->id }}</td>
                            <td class="py-4 px-5">
                                <span class="font-semibold text-slate-800 block">{{ $r->equipment->name ?? '-' }}</span>
                                <span class="text-xs text-slate-400 font-mono">{{ $r->equipment->equipment_code ?? '' }}</span>
                            </td>
                            <td class="py-4 px-5 font-medium text-slate-700">
                                {{ $r->engineer->username ?? '-' }}
                            </td>
                            <td class="py-4 px-5">
                                <span class="inline-block px-2.5 py-0.5 text-[10px] font-bold tracking-wider rounded border {{ $pStyle }}">
                                    {{ $r->priority }}
                                </span>
                            </td>
                            <td class="py-4 px-5">
                                <span class="inline-block px-2.5 py-1 text-[11px] font-semibold rounded-full border {{ $sStyle }}">
                                    {{ str_replace('_', ' ', $r->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-5 text-slate-600 max-w-xs truncate" title="{{ $r->description }}">
                                {{ $r->description }}
                            </td>
                            <td class="py-4 px-5 text-xs text-slate-400 whitespace-nowrap">
                                {{ $r->created_at?->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400 text-sm font-medium">
                                Belum ada history maintenance.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($history->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $history->links() }}
            </div>
        @endif
    </div>
</div>
@endsection