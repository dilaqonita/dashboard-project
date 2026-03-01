<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poly Games Cafe — @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&family=DM+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .font-mono { font-family: 'Roboto Mono', monospace; }
    </style>

    {{-- Style spesifik per-halaman --}}
    @stack('styles')
</head>
<body class="bg-white text-zinc-900 antialiased">

    {{-- Mobile Overlay --}}
    <div id="sidebar-overlay"
         class="fixed inset-0 bg-black/40 z-20 hidden lg:hidden"
         onclick="toggleSidebar()">
    </div>

    <div class="flex h-screen overflow-hidden">

        {{-- ===== SIDEBAR ===== --}}
        <aside id="sidebar"
               class="fixed lg:relative z-30 w-64 h-full bg-white border-r border-zinc-100 flex flex-col justify-between
                      -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shrink-0">

            {{-- Logo --}}
            <div>
                <div class="h-16 px-5 flex items-center gap-3 border-b border-zinc-100">
                    <div class="w-9 h-9 bg-purple-600/10 rounded-2xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.67" viewBox="0 0 20 20">
                            <rect x="1.67" y="1.67" width="16" height="16" rx="2"/>
                            <path d="M5 5h2M5 10h2M5 15h2"/>
                            <path d="M10 5h5M10 10h5M10 15h5"/>
                        </svg>
                    </div>
                    <span class="font-mono font-bold text-zinc-900 text-base leading-7 whitespace-nowrap">Poly Games Cafe</span>
                </div>

                {{-- Navigation --}}
                <nav class="px-3 pt-6 space-y-1">
                    <p class="px-4 mb-3 text-[10px] font-bold uppercase tracking-widest text-gray-400">Main Menu</p>

                    @php
                        $currentRoute = request()->routeIs('overtime*') ? 'overtime'
                            : (request()->routeIs('payroll*') ? 'payroll'
                            : (request()->routeIs('evaluations*') ? 'evaluations'
                            : (request()->routeIs('food-allowance*') ? 'food-allowance'
                            : (request()->routeIs('settings*') ? 'settings'
                            : 'dashboard'))));

                        $navItems = [
                            ['label' => 'Dashboard',         'route' => route('dashboard'),           'key' => 'dashboard',      'icon' => 'dashboard'],
                            ['label' => 'Evaluations',       'route' => route('evaluations.index'),   'key' => 'evaluations',    'icon' => 'evaluations'],
                            ['label' => 'Payroll',           'route' => route('payroll.index'),       'key' => 'payroll',        'icon' => 'payroll'],
                            ['label' => 'Food Allowance',    'route' => route('food-allowance.index'),'key' => 'food-allowance', 'icon' => 'food'],
                            ['label' => 'Overtime Requests', 'route' => route('overtime.index'),      'key' => 'overtime',       'icon' => 'overtime'],
                        ];
                    @endphp

                    @foreach ($navItems as $item)
                        @php $isActive = ($currentRoute === $item['key']); @endphp
                        <a href="{{ $item['route'] }}"
                           class="group flex items-center gap-3 px-4 h-10 rounded-2xl transition-all duration-150
                                  {{ $isActive
                                      ? 'bg-purple-600/5 shadow-sm text-purple-600 font-semibold'
                                      : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-zinc-900' }}">

                            @if ($item['icon'] === 'dashboard')
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                                    <rect x="2" y="2" width="4" height="5" rx="0.5"/>
                                    <rect x="2" y="9.5" width="4" height="4.5" rx="0.5"/>
                                    <rect x="9" y="2" width="5" height="3" rx="0.5"/>
                                    <rect x="9" y="7.5" width="5" height="6.5" rx="0.5"/>
                                </svg>
                            @elseif ($item['icon'] === 'evaluations')
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                                    <path d="M5.33 1.33h5.33a1 1 0 011 1v11.33a1 1 0 01-1 1H5.33a1 1 0 01-1-1V2.33a1 1 0 011-1z"/>
                                    <path d="M6 8h4M6 5.33h2"/>
                                </svg>
                            @elseif ($item['icon'] === 'payroll')
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                                    <line x1="8" y1="1.33" x2="8" y2="14.67"/>
                                    <path d="M4 4.67a2.67 2.67 0 012.67-2.67H9.5"/>
                                    <path d="M4 11.33a2.67 2.67 0 002.67 2.67H10"/>
                                </svg>
                            @elseif ($item['icon'] === 'food')
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                                    <path d="M2 2h1.5v3.5a1.5 1.5 0 003 0V2H8"/>
                                    <path d="M5 5.5v9"/>
                                    <path d="M11 2v12M11 2a3 3 0 010 6"/>
                                </svg>
                            @elseif ($item['icon'] === 'overtime')
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.47" viewBox="0 0 16 16">
                                    <circle cx="8" cy="8" r="6.5"/>
                                    <path d="M8 4.5v3.8l2.5 2.5"/>
                                </svg>
                            @endif

                            <span class="text-sm">{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </nav>
            </div>

            {{-- Settings Footer --}}
            <div class="p-4 border-t border-zinc-100">
                @php $isSettings = ($currentRoute === 'settings'); @endphp
                <a href="{{ route('settings.index') }}"
                   class="flex items-center gap-3 px-2.5 py-3 rounded-2xl transition-colors
                          {{ $isSettings
                              ? 'bg-purple-600/5 outline outline-1 outline-offset-[-1px] outline-purple-600/20'
                              : 'hover:bg-gray-50' }}">
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0
                                {{ $isSettings ? 'bg-purple-600' : 'bg-purple-600/10' }}">
                        <svg class="w-5 h-5 {{ $isSettings ? 'text-white' : 'text-purple-600' }}"
                             fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20">
                            <circle cx="10" cy="10" r="2.5"/>
                            <path d="M17.07 6.57l-1.5-2.6a1 1 0 00-1.22-.45l-1.5.6a6 6 0 00-1.3-.75l-.23-1.6A1 1 0 0010.3 1h-3a1 1 0 00-1 .87l-.23 1.6a6 6 0 00-1.3.75l-1.5-.6a1 1 0 00-1.22.45l-1.5 2.6a1 1 0 00.24 1.28l1.28 1a6.1 6.1 0 000 1.5l-1.28 1a1 1 0 00-.24 1.28l1.5 2.6a1 1 0 001.22.45l1.5-.6c.4.28.84.52 1.3.75l.23 1.6a1 1 0 001 .87h3a1 1 0 001-.87l.23-1.6c.46-.23.9-.47 1.3-.75l1.5.6a1 1 0 001.22-.45l1.5-2.6a1 1 0 00-.24-1.28l-1.28-1a6.1 6.1 0 000-1.5l1.28-1a1 1 0 00.24-1.28z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold leading-tight
                                  {{ $isSettings ? 'text-purple-600' : 'text-zinc-900' }}">Settings</p>
                        <p class="text-[10px] font-medium text-gray-500 capitalize">Staff Controls</p>
                    </div>
                </a>
            </div>
        </aside>

        {{-- ===== MAIN AREA ===== --}}
        <div class="flex flex-col flex-1 min-w-0 overflow-hidden">

            {{-- Top Navbar --}}
            <header class="h-16 px-4 sm:px-8 bg-white/80 backdrop-blur border-b border-zinc-100 flex items-center justify-between shrink-0 z-10">
                <button onclick="toggleSidebar()"
                        class="lg:hidden p-2 -ml-2 rounded-xl hover:bg-gray-100 transition-colors"
                        aria-label="Toggle menu">
                    <svg class="w-5 h-5 text-zinc-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div class="flex items-center gap-2 px-3 py-1 bg-emerald-50 rounded-full border border-emerald-100">
                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full opacity-70 animate-pulse"></span>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-700">Live System</span>
                </div>

                <div class="flex items-center gap-3 pl-4 border-l border-zinc-100">
                    <div class="relative">
                        <button class="w-9 h-9 rounded-2xl flex items-center justify-center hover:bg-gray-100 transition-colors">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.67" viewBox="0 0 20 20">
                                <path d="M10 2a6 6 0 00-6 6v3.5L2.5 13.5h15L16 11.5V8a6 6 0 00-6-6z"/>
                                <path d="M8 15.5a2 2 0 004 0"/>
                            </svg>
                        </button>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-purple-600 rounded-full border-2 border-white"></span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 bg-purple-600/10 rounded-xl border border-purple-600/5 flex items-center justify-center">
                            <span class="text-xs font-bold text-purple-600">J</span>
                        </div>
                        <span class="hidden sm:block text-xs font-bold text-zinc-900/80">John Lennon</span>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto bg-white">
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Sidebar toggle --}}
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const isOpen  = !sidebar.classList.contains('-translate-x-full');
            if (isOpen) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            } else {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            }
        }
    </script>

    {{-- JS spesifik per-halaman — HARUS di sini agar DOM sudah siap --}}
    @stack('scripts')

</body>
</html>