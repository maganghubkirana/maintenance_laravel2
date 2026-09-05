@extends('layouts.app')

@section('title', 'Engineer Workstation')
@section('page_title', 'Tugas & Perbaikan Saya')

@section('content')
<div class="space-y-6">
    <!-- Grid Status Pekerjaan -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-amber-100 shadow-sm bg-gradient-to-br from-amber-50/50 to-white">
            <span class="text-xs font-bold text-amber-600 uppercase tracking-wider block">Tugas Menunggu Kategori</span>
            <div class="text-3xl font-extrabold text-amber-600 mt-2">{{ $myPendingTickets }}</div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-blue-100 shadow-sm bg-gradient-to-br from-blue-50/50 to-white">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider block">Sedang Saya Kerjakan</span>
            <div class="text-3xl font-extrabold text-blue-600 mt-2">{{ $myActiveTickets }}</div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-emerald-100 shadow-sm bg-gradient-to-br from-emerald-50/50 to-white">
            <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider block">Selesai Ditangani</span>
            <div class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $myDoneTickets }}</div>
        </div>
    </div>

    <!-- Daftar Tugas Tiket Aktif -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-slate-900">Daftar Penugasan Tiket</h3>
            <a href="{{ route('tickets.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Lihat Semua →</a>
        </div>
        <div class="space-y-3">
            @forelse($myTickets as $ticket)
                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-100 hover:border-slate-200 transition bg-slate-50/30">
                    <div>
                        <span class="text-xs font-mono font-bold text-blue-600">#{{ $ticket->id }}</span>
                        <h4 class="text-sm font-semibold text-slate-800 mt-0.5">{{ $ticket->title ?? 'Laporan Maintenance' }}</h4>
                        <span class="text-xs text-slate-400">Dibuat: {{ $ticket->created_at->diffForHumans() }}</span>
                    </div>
                    <a href="{{ route('tickets.show', $ticket->id) }}" class="px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs">
                        Kerjakan
                    </a>
                </div>
            @empty
                <div class="text-center py-8 text-slate-400 text-sm">Tidak ada tugas perbaikan aktif yang ditugaskan kepada Anda.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection