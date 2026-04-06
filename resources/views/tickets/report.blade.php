@extends('layouts.app')

@section('content')

    <div class="max-w-7xl mx-auto print:hidden">
        
        <div class="flex justify-between items-end mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800"><i class="fa-solid fa-chart-pie text-primary mr-2"></i> Laporan Tiket IT</h1>
                <p class="text-sm text-gray-500 mt-1">Filter dan cetak rekapitulasi penanganan tiket.</p>
            </div>
            
            <button onclick="window.print()" class="bg-primary hover:bg-teal-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition-all flex items-center gap-2">
                <i class="fa-solid fa-print"></i> Cetak Laporan
            </button>
        </div>

        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 mb-8">
            <form action="{{ route('admin.tickets.report') }}" method="GET" class="flex flex-col lg:flex-row gap-5 items-end">
                
                <div class="flex-1 w-full">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Awal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-primary focus:ring-1 focus:ring-primary outline-none text-sm bg-gray-50">
                </div>
                
                <div class="flex-1 w-full">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-primary focus:ring-1 focus:ring-primary outline-none text-sm bg-gray-50">
                </div>

                <div class="flex-1 w-full">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Status Tiket</label>
                    <select name="status" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-primary focus:ring-1 focus:ring-primary outline-none text-sm bg-gray-50 font-medium">
                        <option value="All" {{ request('status') == 'All' ? 'selected' : '' }}>Semua Status</option>
                        <option value="New" {{ request('status') == 'New' ? 'selected' : '' }}>🟢 New</option>
                        <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>🔵 Open</option>
                        <option value="On-hold" {{ request('status') == 'On-hold' ? 'selected' : '' }}>🟡 On-hold</option>
                        <option value="Resolved" {{ request('status') == 'Resolved' ? 'selected' : '' }}>⚪ Resolved</option>
                    </select>
                </div>

                <div class="w-full lg:w-auto flex gap-3">
                    <button type="submit" class="flex-1 bg-gray-800 hover:bg-gray-900 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-md">
                        Filter Data
                    </button>
                    
                    @if(request()->has('start_date'))
                        <a href="{{ route('admin.tickets.report') }}" class="flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-5 rounded-xl transition-all border border-gray-200" title="Reset Filter">
                            <i class="fa-solid fa-rotate-right"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto bg-white print:shadow-none print:border-none rounded-2xl shadow-sm border border-gray-100 overflow-hidden" id="print-area">
        
        <div class="hidden print:block mb-4 pt-2">
            
            @php
                $adminLoc = auth()->user()->location ?? '';
                if (\Illuminate\Support\Str::contains($adminLoc, ['Krian', 'Sidoarjo'])) {
                    $alamat = 'Jl. Bypass Krian, Ds. Sidomojo, Krian Sidoarjo';
                    $telp = '(031) 8982349';
                } elseif (\Illuminate\Support\Str::contains($adminLoc, ['Mojoagung', 'Jombang'])) {
                    $alamat = 'Jl. Raya Mojoagung No. 123, Kab. Jombang, Jawa Timur';
                    $telp = '(0321) 489000';
                } elseif (\Illuminate\Support\Str::contains($adminLoc, 'Batang')) {
                    $alamat = 'Kawasan Industri Terpadu (KIT) Batang, Jawa Tengah';
                    $telp = '(0285) 390000';
                } else {
                    $alamat = 'Jl. Bypass Krian, Ds. Sidomojo, Krian Sidoarjo';
                    $telp = '(031) 8982349';
                }
            @endphp

            <div class="flex justify-between items-center pb-3 border-b-[3px] border-black">
                <div class="w-1/4">
                    <img src="{{ asset('images/logo-jmi.png') }}" alt="JMI Logo" class="h-14 object-contain">
                </div>

                <div class="w-2/4 text-center text-black" style="font-family: 'Times New Roman', Times, serif;">
                    <h1 class="text-xl font-extrabold tracking-wide mb-0.5">PT JAYAMAS MEDICA INDUSTRI TBK</h1>
                    <p class="text-[14px] leading-tight">{{ $alamat }}</p>
                    <p class="text-[14px] leading-tight">Telp. {{ $telp }}</p>
                    <p class="text-[14px] leading-tight">Website: https://www.onemed.co.id/</p>
                </div>

                <div class="w-1/4 flex justify-end">
                    <img src="{{ asset('images/onemed-logo.png') }}" alt="OneMed Logo" class="h-14 object-contain">
                </div>
            </div>
            
            <div class="border-b border-black mt-0.5 mb-2"></div>

            <div class="relative mt-8 mb-8">
                <h2 class="text-lg font-bold text-black uppercase tracking-wider text-center" style="font-family: 'Times New Roman', Times, serif;">
                    LAPORAN REKAPITULASI TIKET IT
                </h2>
                
                <div class="absolute right-0 top-0 text-black font-bold text-[13px]" style="font-family: 'Times New Roman', Times, serif;">
                    Tanggal: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
                </div>
            </div>
        </div>

        <div class="overflow-x-auto p-0 print:p-0">
            <table class="w-full text-left border-collapse print:text-sm">
                <thead>
                    <tr class="text-xs text-gray-400 uppercase tracking-wider border-b border-gray-100 bg-gray-50/80 print:bg-transparent print:border-b-2 print:border-gray-800 print:text-black">
                        <th class="py-4 px-6 print:py-2 print:px-3 font-bold">No. Tiket</th>
                        <th class="py-4 px-6 print:py-2 print:px-3 font-bold">Tanggal</th>
                        <th class="py-4 px-6 print:py-2 print:px-3 font-bold">Pelapor & Divisi</th>
                        <th class="py-4 px-6 print:py-2 print:px-3 font-bold">Kendala</th>
                        <th class="py-4 px-6 print:py-2 print:px-3 font-bold">Penanganan</th> 
                        <th class="py-4 px-6 print:py-2 print:px-3 font-bold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-50 print:divide-gray-300">
                    @forelse ($tickets as $ticket)
                    <tr class="hover:bg-gray-50/80 transition-colors">
                        <td class="py-4 px-6 print:py-2 print:px-3 font-mono font-bold text-primary print:text-black">{{ $ticket->ticket_number }}</td>
                        <td class="py-4 px-6 print:py-2 print:px-3 text-gray-500 print:text-gray-800">{{ $ticket->created_at->format('d/m/Y') }}</td>
                        <td class="py-4 px-6 print:py-2 print:px-3 text-gray-700 font-medium">
                            <div class="flex flex-col">
                                <span class="print:text-black">{{ $ticket->requester_name }}</span>
                                <span class="text-xs text-gray-400 font-normal mt-0.5 print:text-gray-600">{{ $ticket->divisi }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 print:py-2 print:px-3 text-gray-700 print:text-black">{{ Str::limit($ticket->subject, 40) }}</td>
                        
                        <td class="py-4 px-6 print:py-2 print:px-3">
                            <div class="flex flex-col gap-1.5">
                                @if($ticket->assigned_to)
                                    <span class="font-bold text-gray-800 text-xs flex items-center gap-1.5 print:text-black">
                                        <i class="fa-solid fa-user-gear text-primary print:hidden"></i> {{ $ticket->assigned_to }}
                                    </span>
                                    
                                    @if($ticket->started_at && $ticket->finished_at)
                                        <div class="flex flex-col gap-1">
                                            <span class="text-[10px] text-gray-500 font-medium flex items-center gap-1.5 print:text-gray-800 print:text-xs">
                                                <i class="fa-regular fa-clock print:hidden"></i> {{ $ticket->started_at->format('H:i') }} - {{ $ticket->finished_at->format('H:i') }} WIB
                                            </span>
                                            <span class="text-[11px] font-bold text-green-700 bg-green-50 border border-green-200 px-2 py-0.5 rounded w-fit print:p-0 print:bg-transparent print:border-none print:text-gray-800">
                                                <i class="fa-solid fa-stopwatch mr-1 print:hidden"></i> {{ $ticket->started_at->diffForHumans($ticket->finished_at, true) }}
                                            </span>
                                        </div>
                                    @elseif($ticket->started_at)
                                        <div class="flex flex-col gap-1">
                                            <span class="text-[10px] text-gray-500 font-medium flex items-center gap-1.5 print:text-gray-800 print:text-xs">
                                                <i class="fa-regular fa-clock print:hidden"></i> Mulai: {{ $ticket->started_at->format('H:i') }} WIB
                                            </span>
                                            <span class="text-[11px] font-medium text-blue-600 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded w-fit print:p-0 print:bg-transparent print:border-none print:text-gray-800">
                                                <i class="fa-solid fa-spinner fa-spin mr-1 print:hidden"></i> Sedang diproses
                                            </span>
                                        </div>
                                    @endif
                                @else
                                    <span class="text-xs text-red-500 italic flex items-center gap-1.5 print:text-gray-600">
                                        <i class="fa-solid fa-triangle-exclamation print:hidden"></i> Belum ditugaskan
                                    </span>
                                @endif
                            </div>
                        </td>

                        <td class="py-4 px-6 print:py-2 print:px-3 text-center">
                            <span class="font-bold text-xs uppercase text-gray-600 print:text-black">{{ $ticket->status }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center">
                            <div class="w-16 h-16 bg-gray-50 text-gray-300 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl">
                                <i class="fa-solid fa-folder-open"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Tidak ada data tiket pada rentang waktu/status tersebut.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="hidden print:flex justify-end mt-16 pr-12 pb-12">
            <div class="text-center">
                <p class="text-sm text-gray-800 mb-20" style="font-family: 'Times New Roman', Times, serif;">Mengetahui,</p>
                <p class="font-bold text-gray-800 underline uppercase">{{ auth()->user()->name ?? 'Admin IT' }}</p>
                <p class="text-xs text-gray-500">IT Support Manager</p>
            </div>
        </div>

    </div>

    <style>
        @media print {
            /* Kertas dikembalikan ke ukuran A4 default (Portrait) sesuai gambar Anda */
            @page { 
                size: A4; 
                margin: 0mm; 
            }
            
            body { 
                margin: 0 !important;
                background-color: white !important; 
            }
            
            * { 
                -webkit-print-color-adjust: exact !important; 
                color-adjust: exact !important; 
            }

            body * { 
                visibility: hidden; 
            }
            
            #print-area, #print-area * { 
                visibility: visible; 
            }
            
            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 1.5cm !important;
                box-sizing: border-box;
            }
            
            .overflow-x-auto {
                overflow: visible !important;
            }
            
            table {
                width: 100% !important;
                table-layout: auto !important;
                border-collapse: collapse !important;
            }
            
            th, td {
                word-wrap: break-word !important;
                white-space: normal !important;
                overflow-wrap: break-word !important;
            }
        }
    </style>
@endsection