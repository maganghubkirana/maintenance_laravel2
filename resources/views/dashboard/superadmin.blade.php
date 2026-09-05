@extends('layouts.app')

@section('title', 'Superadmin Dashboard')
@section('page_title', 'System Administration Overview')

@section('content')
<div class="space-y-6">
    <!-- Banner Sambutan -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-6 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-xl font-bold">Selamat Datang, {{ auth()->user()->username }} 👋</h2>
            <p class="text-slate-300 text-sm mt-1">Sistem berjalan dengan aman. Berikut adalah ringkasan performa dan inventaris infrastruktur.</p>
        </div>
    </div>

    <!-- Ringkasan Metric Utama -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Pengguna Terdaftar</span>
                <span class="text-3xl font-extrabold text-slate-900 mt-1 block">{{ $totalUsers }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xl">👥</div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Tiket Sistem</span>
                <span class="text-3xl font-extrabold text-blue-600 mt-1 block">{{ $totalTickets }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xl">🎫</div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Total Equipment</span>
                <span class="text-3xl font-extrabold text-emerald-600 mt-1 block">{{ $totalEquipment }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-xl">⚙️</div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Jenis Spareparts</span>
                <span class="text-3xl font-extrabold text-purple-600 mt-1 block">{{ $totalSpareparts }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold text-xl">📦</div>
        </div>
    </div>

    <!-- Tabel Aktivitas Tiket Terbaru -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
        <h3 class="text-base font-bold text-slate-900 mb-4">Tiket Maintenance Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 uppercase text-xs font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-4 py-3">ID Tiket</th>
                        <th class="px-4 py-3">Pelapor</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentTickets as $ticket)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-4 py-3 font-mono font-medium text-slate-900">#{{ $ticket->id }}</td>
                            <td class="px-4 py-3">{{ $ticket->user->username ?? 'Sistem' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 text-xs font-bold rounded-lg uppercase tracking-wide
                                    {{ $ticket->status == 'completed' ? 'bg-emerald-100 text-emerald-700' : ($ticket->status == 'in_progress' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700') }}">
                                    {{ $ticket->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-400">{{ $ticket->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-slate-400">Belum ada tiket terekam.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection