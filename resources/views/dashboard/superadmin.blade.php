@extends('layouts.app')

@section('title', 'Superadmin Dashboard')
@section('page_title', 'Dashboard Overview')

@section('content')
<!-- Ringkasan Stat / Widget Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80">
        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Users</span>
        <div class="flex items-center justify-between">
            <h3 class="text-3xl font-extrabold text-slate-800">{{ $totalUsers }}</h3>
            <span class="p-2.5 bg-blue-50 text-blue-600 rounded-xl text-lg">👥</span>
        </div>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80">
        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Tiket</span>
        <div class="flex items-center justify-between">
            <h3 class="text-3xl font-extrabold text-slate-800">{{ $totalTickets }}</h3>
            <span class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl text-lg">🎫</span>
        </div>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80">
        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Equipment</span>
        <div class="flex items-center justify-between">
            <h3 class="text-3xl font-extrabold text-slate-800">{{ $totalEquipment }}</h3>
            <span class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl text-lg">⚙️</span>
        </div>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80">
        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Total Spareparts</span>
        <div class="flex items-center justify-between">
            <h3 class="text-3xl font-extrabold text-slate-800">{{ $totalSpareparts }}</h3>
            <span class="p-2.5 bg-amber-50 text-amber-600 rounded-xl text-lg">📦</span>
        </div>
    </div>
</div>

<!-- Tabel Tiket Terbaru -->
<div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
    <div class="p-5 border-b border-slate-100 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 text-lg">Tiket Terbaru</h3>
        <a href="{{ route('tickets.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700">Lihat Semua →</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="bg-slate-50/50 text-slate-500 font-semibold border-b border-slate-100">
                    <th class="p-4">ID</th>
                    <th class="p-4">Judul Ticket</th>
                    <th class="p-4">Prioritas</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                @forelse($recentTickets as $ticket)
                    <tr class="hover:bg-slate-50/60 transition-all">
                        <td class="p-4 font-mono font-medium text-slate-400">#{{ $ticket->id }}</td>
                        <td class="p-4 font-medium text-slate-800">{{ $ticket->title }}</td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 text-xs font-bold rounded-lg uppercase
                                {{ $ticket->priority === 'high' ? 'bg-rose-100 text-rose-700' : '' }}
                                {{ $ticket->priority === 'medium' ? 'bg-amber-100 text-amber-700' : '' }}
                                {{ $ticket->priority === 'low' ? 'bg-slate-100 text-slate-600' : '' }}">
                                {{ $ticket->priority }}
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 text-xs font-bold rounded-lg capitalize
                                {{ $ticket->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ str_replace('_', ' ', $ticket->status) }}
                            </span>
                        </td>
                        <td class="p-4 text-xs text-slate-400">{{ $ticket->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400">Belum ada data tiket.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection