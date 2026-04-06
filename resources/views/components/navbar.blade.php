<header
    class="bg-white border-b border-gray-100 py-4 px-6 md:px-8 flex justify-between items-center shadow-sm z-10 print:hidden">

    <div class="flex items-center">
    </div>

    <div class="flex items-center gap-4 sm:gap-6">

        <button class="relative text-gray-400 hover:text-[#EA580C] transition-colors">
            <i class="fa-solid fa-bell text-xl"></i>
            <span class="absolute -top-0.5 -right-0.5 flex h-3 w-3">
                <span
                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#EA580C] opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-[#EA580C] border-2 border-white"></span>
            </span>
        </button>

        <div class="hidden sm:block h-8 w-px bg-gray-200"></div>

        <div class="flex items-center gap-3">
            <div class="hidden sm:block text-right">
                <p class="text-sm font-bold text-gray-800">{{ auth()->user()->name ?? 'Admin IT' }}</p>
                <p class="text-[11px] font-medium text-gray-500 tracking-wide">
                    {{ auth()->user()->role ?? 'IT Administrator' }}
                </p>
            </div>

            @php
                $name = auth()->user()->name ?? 'Admin';
                $initials = collect(explode(' ', $name))->map(function ($segment) {
                    return strtoupper(substr($segment, 0, 1));
                })->take(2)->join('');
            @endphp
            <div
                class="w-10 h-10 rounded-full bg-[#EA580C] text-white font-extrabold flex items-center justify-center shadow-sm border-2 border-white">
                {{ $initials }}
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="m-0 ml-1">
            @csrf
            <button type="submit"
                class="bg-red-50 hover:bg-red-500 text-red-500 hover:text-white h-10 px-4 rounded-xl text-sm font-bold flex items-center gap-2 transition-all border border-red-100 hover:border-red-500 shadow-sm group"
                title="Logout">
                <i class="fa-solid fa-power-off group-hover:scale-110 transition-transform"></i>
                <span class="hidden md:inline">Logout</span>
            </button>
        </form>

    </div>
</header>