@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">

        @if(session('success'))
            <div
                class="mb-6 px-4 py-3 bg-green-100 text-green-700 rounded-xl shadow-sm font-medium flex items-center gap-2 border border-green-200">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    @if(request('status'))
                        Menampilkan Tiket: <span class="text-primary">{{ strtoupper(request('status')) }}</span>
                    @else
                        Semua Tiket
                    @endif
                </h1>
                <p class="text-sm text-gray-500 mt-1">Daftar antrean pengaduan IT Support</p>
            </div>

            <form action="{{ route('admin.tickets.index') }}" method="GET" class="relative w-full md:w-96">
                @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                <button type="submit"
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-primary transition-colors">
                    <i class="fa-solid fa-search"></i>
                </button>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari no tiket, subjek, atau nama..."
                    class="w-full pl-11 pr-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary text-sm shadow-sm bg-white">
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mt-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="text-[11px] text-gray-400 uppercase tracking-widest border-b border-gray-100 bg-gray-50/50">
                            <th class="py-4 px-6 font-extrabold w-[10%]">PRIORITY</th>
                            <th class="py-4 px-6 font-extrabold w-[15%]">NO. TIKET</th>
                            <th class="py-4 px-6 font-extrabold w-[45%]">KENDALA</th>
                            <th class="py-4 px-6 font-extrabold w-[20%]">PELAPOR & DIVISI</th>
                            <th class="py-4 px-6 font-extrabold w-[10%] text-center">AKSI</th>
                        </tr>
                    </thead>

                    <tbody class="text-sm divide-y divide-gray-50">
                        @forelse ($tickets as $ticket)
                            <tr class="hover:bg-gray-50/80 transition-colors group">

                                <td class="py-4 px-6 whitespace-nowrap">
                                    @php
                                        $colorClass = match ($ticket->priority) {
                                            'Low' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                            'Critical' => 'bg-red-50 text-red-700 border-red-100',
                                            'Medium' => 'bg-blue-50 text-blue-700 border-blue-100',
                                            'High' => 'bg-pink-50 text-pink-700 border-pink-100',
                                            default => 'bg-gray-50 text-gray-700 border-gray-100'
                                        };
                                    @endphp
                                    <span
                                        class="px-3 py-1 rounded-md text-[11px] uppercase tracking-wider font-bold border {{ $colorClass }}">
                                        {{ $ticket->priority }}
                                    </span>
                                </td>

                                <td class="py-4 px-6 whitespace-nowrap">
                                    <span
                                        class="font-mono font-bold text-teal-600 text-sm tracking-wide">{{ $ticket->ticket_number }}</span>
                                </td>

                                <td class="py-4 px-6 text-gray-700 font-medium leading-relaxed">
                                    {{ Str::limit($ticket->subject, 60) }}
                                </td>

                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-800">{{ $ticket->requester_name }}</span>
                                        <span class="text-xs text-gray-500 font-medium mt-0.5 flex items-center gap-1">
                                            <i class="fa-regular fa-building opacity-70"></i> {{ $ticket->divisi }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center whitespace-nowrap">
                                    <a href="{{ route('admin.tickets.show', $ticket->id) }}"
                                        class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-bold text-teal-600 bg-teal-50 border border-teal-100 hover:bg-teal-500 hover:text-white transition-all shadow-sm">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center">
                                    <div
                                        class="w-16 h-16 bg-gray-50 text-gray-300 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl">
                                        <i class="fa-solid fa-folder-open"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Belum ada tiket pada kategori ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($tickets->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $tickets->links('pagination::tailwind') }}
            </div>
        @endif
    </div>

    </div>
@endsection