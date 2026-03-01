<aside x-data="{ openKasbon: {{ request()->is('staff/food-allowance*') ? 'true' : 'false' }} }" 
    class="w-64 bg-white border-r border-gray-100 flex flex-col min-h-screen shadow-sm">
    
    <div class="p-6 border-b border-gray-50">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center text-white font-bold">
                P
            </div>
            <span class="font-bold text-gray-800 tracking-tight text-lg">Poly Staff</span>
        </div>
    </div>

    <nav class="flex-1 p-4 space-y-1">
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-3 mb-2">Main Menu</p>

        <a href="{{ route('staff.dashboard') }}" 
           class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('staff.dashboard') ? 'bg-purple-50 text-purple-700 font-semibold' : 'text-gray-500 hover:bg-gray-50' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="text-sm font-medium">Dashboard</span>
        </a>

        <a href="{{ route('staff.payroll') }}" 
           class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('staff.payroll') ? 'bg-purple-50 text-purple-700 font-semibold' : 'text-gray-500 hover:bg-gray-50' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-sm font-medium">Payroll</span>
        </a>

        <div>
            <button @click="openKasbon = !openKasbon" 
                class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-gray-500 hover:bg-gray-50 transition-all focus:outline-none">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="text-sm font-medium">Kasbon</span>
                </div>
                <svg :class="openKasbon ? 'rotate-180' : ''" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div x-show="openKasbon" 
                 x-transition:enter="transition ease-out duration-100" 
                 x-transition:enter-start="opacity-0 -translate-y-2" 
                 class="mt-1 ml-9 space-y-1 border-l-2 border-gray-100 pl-2">
                <a href="{{ route('staff.food-allowance') }}" 
                   class="block px-3 py-2 text-xs rounded-lg transition-all {{ request()->routeIs('staff.food-allowance') ? 'text-purple-700 font-bold bg-purple-50' : 'text-gray-500 hover:text-gray-800' }}">
                    Food Allowance
                </a>
                <a href="#" 
                   class="block px-3 py-2 text-xs rounded-lg transition-all text-gray-500 hover:text-gray-800 italic">
                    Lainnya...
                </a>
            </div>
        </div>

        <a href="{{ route('staff.overtime') }}" 
           class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all {{ request()->routeIs('staff.overtime') ? 'bg-purple-50 text-purple-700 font-semibold' : 'text-gray-500 hover:bg-gray-50' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-sm font-medium">Overtime</span>
        </a>
    </nav>

    <div class="p-4 border-t border-gray-50">
        <div class="bg-gray-50 rounded-xl p-3">
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tight">Status</p>
            <p class="text-[11px] text-green-600 font-semibold">Active Session</p>
        </div>
    </div>
</aside>