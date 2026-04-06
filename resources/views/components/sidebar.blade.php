<div class="w-[280px] bg-[#162A4A] flex flex-col h-screen flex-shrink-0 z-20 print:hidden shadow-xl text-white">

    <div class="p-6 border-b border-white/10 flex flex-col items-center justify-center gap-4 bg-[#0F1E36]/80">

        <a href="{{ route('admin.tickets.index') }}"
            class="flex items-center gap-3 transform transition-transform duration-300 hover:scale-105 bg-white p-2.5 rounded-2xl shadow-md border border-gray-100">
            <img src="{{ asset('images/onemed-logo.png') }}" alt="OneMed" class="h-8 w-auto object-contain">
            <div class="h-6 w-px bg-gray-200"></div>
            <img src="{{ asset('images/logo-jmi.png') }}" alt="JMI" class="h-8 w-auto object-contain">
        </a>

        <div
            class="w-full bg-[#EA580C] px-3 py-2.5 rounded-xl text-xs font-extrabold text-white flex items-center justify-center gap-2 shadow-md">
            <i class="fa-solid fa-location-dot"></i> {{ auth()->user()->location ?? 'Super Admin' }}
        </div>
    </div>

    <div class="px-5 py-6 flex-1 overflow-y-auto">
        <h2 class="text-blue-300/60 font-extrabold mb-4 text-[11px] uppercase tracking-widest pl-1">Status Antrean</h2>

        @php $currentStatus = request('status'); @endphp

        <ul class="space-y-2.5">
            @php $isAll = !$currentStatus && request()->routeIs('admin.tickets.index'); @endphp
            <li>
                <a href="{{ route('admin.tickets.index') }}"
                    class="flex justify-between items-center px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 border {{ $isAll ? 'bg-[#EA580C] text-white border-[#EA580C] shadow-lg transform scale-[1.02]' : 'bg-[#1E365D] text-gray-300 hover:bg-[#284675] hover:text-white border-transparent shadow-sm' }}">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg flex items-center justify-center {{ $isAll ? 'bg-white/20' : 'bg-[#0F1E36] text-gray-400' }}">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <span>Semua Tiket</span>
                    </div>
                    <span
                        class="text-xs px-2.5 py-1 rounded-full font-extrabold {{ $isAll ? 'bg-white text-[#EA580C]' : 'bg-[#0F1E36] text-gray-400' }}">{{ $counts['All'] ?? 0 }}</span>
                </a>
            </li>

            @php $isNew = $currentStatus == 'New'; @endphp
            <li>
                <a href="{{ route('admin.tickets.index', ['status' => 'New']) }}"
                    class="flex justify-between items-center px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 border {{ $isNew ? 'bg-green-500 text-white border-green-500 shadow-lg transform scale-[1.02]' : 'bg-[#1E365D] text-gray-300 hover:bg-[#284675] hover:text-white border-transparent shadow-sm' }}">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg flex items-center justify-center {{ $isNew ? 'bg-white/20' : 'bg-[#0F1E36] text-gray-400' }}">
                            <i class="fa-solid fa-inbox"></i>
                        </div>
                        <span>Tiket Baru</span>
                    </div>
                    <span
                        class="text-xs px-2.5 py-1 rounded-full font-extrabold {{ $isNew ? 'bg-white text-green-600' : 'bg-[#0F1E36] text-gray-400' }}">{{ $counts['New'] ?? 0 }}</span>
                </a>
            </li>

            @php $isOpen = $currentStatus == 'Open'; @endphp
            <li>
                <a href="{{ route('admin.tickets.index', ['status' => 'Open']) }}"
                    class="flex justify-between items-center px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 border {{ $isOpen ? 'bg-blue-500 text-white border-blue-500 shadow-lg transform scale-[1.02]' : 'bg-[#1E365D] text-gray-300 hover:bg-[#284675] hover:text-white border-transparent shadow-sm' }}">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg flex items-center justify-center {{ $isOpen ? 'bg-white/20' : 'bg-[#0F1E36] text-gray-400' }}">
                            <i class="fa-solid fa-wrench"></i>
                        </div>
                        <span>Dikerjakan</span>
                    </div>
                    <span
                        class="text-xs px-2.5 py-1 rounded-full font-extrabold {{ $isOpen ? 'bg-white text-blue-600' : 'bg-[#0F1E36] text-gray-400' }}">{{ $counts['Open'] ?? 0 }}</span>
                </a>
            </li>

            @php $isOnHold = $currentStatus == 'On-hold'; @endphp
            <li>
                <a href="{{ route('admin.tickets.index', ['status' => 'On-hold']) }}"
                    class="flex justify-between items-center px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 border {{ $isOnHold ? 'bg-yellow-500 text-white border-yellow-500 shadow-lg transform scale-[1.02]' : 'bg-[#1E365D] text-gray-300 hover:bg-[#284675] hover:text-white border-transparent shadow-sm' }}">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg flex items-center justify-center {{ $isOnHold ? 'bg-white/20' : 'bg-[#0F1E36] text-gray-400' }}">
                            <i class="fa-solid fa-pause"></i>
                        </div>
                        <span>Tertunda</span>
                    </div>
                    <span
                        class="text-xs px-2.5 py-1 rounded-full font-extrabold {{ $isOnHold ? 'bg-white text-yellow-600' : 'bg-[#0F1E36] text-gray-400' }}">{{ $counts['On-hold'] ?? 0 }}</span>
                </a>
            </li>

            @php $isResolved = $currentStatus == 'Resolved'; @endphp
            <li>
                <a href="{{ route('admin.tickets.index', ['status' => 'Resolved']) }}"
                    class="flex justify-between items-center px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 border {{ $isResolved ? 'bg-slate-500 text-white border-slate-500 shadow-lg transform scale-[1.02]' : 'bg-[#1E365D] text-gray-300 hover:bg-[#284675] hover:text-white border-transparent shadow-sm' }}">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg flex items-center justify-center {{ $isResolved ? 'bg-white/20' : 'bg-[#0F1E36] text-gray-400' }}">
                            <i class="fa-solid fa-check-double"></i>
                        </div>
                        <span>Selesai</span>
                    </div>
                    <span
                        class="text-xs px-2.5 py-1 rounded-full font-extrabold {{ $isResolved ? 'bg-white text-slate-600' : 'bg-[#0F1E36] text-gray-400' }}">{{ $counts['Resolved'] ?? 0 }}</span>
                </a>
            </li>
        </ul>

        <h2
            class="text-blue-300/60 font-extrabold mb-4 text-[11px] uppercase tracking-widest mt-8 border-t border-white/10 pt-6 pl-1">
            Laporan & Audit</h2>

        @php $isReport = request()->routeIs('admin.tickets.report'); @endphp
        <a href="{{ route('admin.tickets.report') }}"
            class="flex items-center px-4 py-3.5 rounded-xl text-sm font-bold transition-all duration-200 border {{ $isReport ? 'bg-[#EA580C] text-white border-transparent shadow-lg transform scale-[1.02]' : 'bg-white/10 text-gray-200 hover:bg-[#EA580C] hover:text-white border-transparent shadow-sm group' }}">
            <div
                class="w-8 h-8 rounded-lg flex items-center justify-center {{ $isReport ? 'bg-white/20' : 'bg-[#0F1E36] text-gray-300 group-hover:bg-white/20 group-hover:text-white transition-colors' }} mr-3">
                <i class="fa-solid fa-print"></i>
            </div>
            <span>Rekap Laporan</span>
            <i
                class="fa-solid fa-arrow-right ml-auto text-xs {{ $isReport ? 'opacity-50' : 'opacity-70 group-hover:opacity-100' }}"></i>
        </a>
    </div>
</div>