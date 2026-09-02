@extends('layouts.app') {{-- Sesuaikan dengan lokasi file layout Anda (misal: layouts.app atau master) --}}

@section('title', 'Daftar Tiket - Maintenance X')
@section('page_title', 'Tickets')

@section('content')
<div class="space-y-6">
    
    <!-- Header & Tombol Lapor Kerusakan -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Tiket Maintenance</h2>
            <p class="text-sm text-slate-500 mt-0.5">Kelola dan pantau semua laporan kerusakan perangkat di sistem.</p>
        </div>
        <a href="{{ route('tickets.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all shadow-md shadow-blue-500/20">
            + Buat Tiket Baru
        </a>
    </div>

    <!-- Card Grid Ringkasan Ringkas -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Tiket</p>
            <p class="text-2xl font-bold text-slate-800 mt-1">{{ $tickets->total() }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-xs font-semibold text-amber-600 uppercase tracking-wider">Perlu Ditangani (Open)</p>
            <p class="text-2xl font-bold text-amber-600 mt-1">
                {{ $tickets->where('status', 'open')->count() }}
            </p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Sedang Diproses</p>
            <p class="text-2xl font-bold text-blue-600 mt-1">
                {{ $tickets->whereIn('status', ['in_progress', 'pending_sparepart'])->count() }}
            </p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
            <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Selesai (Resolved)</p>
            <p class="text-2xl font-bold text-emerald-600 mt-1">
                {{ $tickets->whereIn('status', ['resolved', 'closed'])->count() }}
            </p>
        </div>
    </div>

    <!-- Tabel Daftar Tiket -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs text-slate-500 uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-4">No. Tiket</th>
                        <th class="px-6 py-4">Perangkat</th>
                        <th class="px-6 py-4">Judul Masalah</th>
                        <th class="px-6 py-4">Pelapor</th>
                        <th class="px-6 py-4">Prioritas</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 font-bold text-blue-600 whitespace-nowrap">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="hover:underline">
                                    {{ $ticket->ticket_number }}
                                </a>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-800 whitespace-nowrap">
                                {{ $ticket->device->name ?? 'Perangkat Dihapus' }}
                                <span class="block text-xs text-slate-400 font-normal">{{ $ticket->device->asset_number ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-slate-800 line-clamp-1">{{ $ticket->title }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $ticket->created_at->format('d M Y, H:i') }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $ticket->reporter->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 text-[11px] font-semibold rounded-full
                                    {{ $ticket->priority == 'urgent' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $ticket->priority == 'high' ? 'bg-orange-100 text-orange-700' : '' }}
                                    {{ $ticket->priority == 'medium' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $ticket->priority == 'low' ? 'bg-slate-100 text-slate-700' : '' }}">
                                    {{ strtoupper($ticket->priority) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 text-[11px] font-bold rounded-full uppercase
                                    {{ $ticket->status == 'open' ? 'bg-amber-100 text-amber-800' : '' }}
                                    {{ $ticket->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $ticket->status == 'pending_sparepart' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ in_array($ticket->status, ['resolved', 'closed']) ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $ticket->status == 'cancelled' ? 'bg-rose-100 text-rose-800' : '' }}">
                                    {{ str_replace('_', ' ', $ticket->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                    Detail & Tracking
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-slate-400 italic">
                                Belum ada tiket pelaporan kerusakan saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Link -->
        @if($tickets->hasPages())
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                {{ $tickets->links() }}
            </div>
        @endif
    </div>

</div>
@endsection