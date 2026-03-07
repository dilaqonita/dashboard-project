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

    {{-- Mobile Overlay (sidebar) --}}
    <div id="sidebar-overlay"
         class="fixed inset-0 bg-black/40 z-20 hidden lg:hidden"
         onclick="toggleSidebar()">
    </div>

    {{-- Notif Overlay (klik luar = tutup panel) --}}
    <div id="notif-overlay"
         class="fixed inset-0 z-30 hidden"
         onclick="closeNotif()">
    </div>

    <div class="flex h-screen overflow-hidden">

        {{-- ===== SIDEBAR ===== --}}
        <aside id="sidebar"
               class="relative z-30 h-full bg-white border-r border-zinc-100 flex flex-col justify-between
                      overflow-hidden transition-[width] duration-300 ease-in-out shrink-0"
               style="width:0">

            {{-- Logo + Close button (mobile) --}}
            <div>
                <div class="h-16 px-5 flex items-center justify-between border-b border-zinc-100">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-purple-600/10 rounded-2xl flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.67" viewBox="0 0 20 20">
                                <rect x="1.67" y="1.67" width="16" height="16" rx="2"/>
                                <path d="M5 5h2M5 10h2M5 15h2"/>
                                <path d="M10 5h5M10 10h5M10 15h5"/>
                            </svg>
                        </div>
                        <span class="font-mono font-bold text-zinc-900 text-base leading-7 whitespace-nowrap">Poly Games Cafe</span>
                    </div>
                    {{-- Close button — tampil di semua ukuran layar, tapi di desktop sidebar selalu terbuka --}}
                    <button onclick="toggleSidebar()"
                            id="sidebar-close-btn"
                            class="w-8 h-8 flex items-center justify-center rounded-xl hover:bg-gray-100 transition-colors"
                            aria-label="Close sidebar">
                        <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
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
                            ['label' => 'Dashboard',         'route' => route('dashboard'),            'key' => 'dashboard',      'icon' => 'dashboard'],
                            ['label' => 'Evaluations',       'route' => route('evaluations.index'),    'key' => 'evaluations',    'icon' => 'evaluations'],
                            ['label' => 'Payroll',           'route' => route('payroll.index'),        'key' => 'payroll',        'icon' => 'payroll'],
                            ['label' => 'Food Allowance',    'route' => route('food-allowance.index'), 'key' => 'food-allowance', 'icon' => 'food'],
                            ['label' => 'Overtime Requests', 'route' => route('overtime.index'),       'key' => 'overtime',       'icon' => 'overtime'],
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
                        <p class="text-sm font-bold leading-tight {{ $isSettings ? 'text-purple-600' : 'text-zinc-900' }}">Settings</p>
                        <p class="text-[10px] font-medium text-gray-500 capitalize">Staff Controls</p>
                    </div>
                </a>
            </div>
        </aside>

        {{-- ===== MAIN AREA ===== --}}
        <div class="flex flex-col flex-1 min-w-0 overflow-hidden">

            {{-- ===== TOP NAVBAR ===== --}}
            <header class="h-16 px-3 sm:px-6 bg-white/80 backdrop-blur border-b border-zinc-100 flex items-center justify-between shrink-0 z-10">

                {{-- Kiri: Hamburger + Live Badge --}}
                <div class="flex items-center gap-3">
                    {{-- Hamburger — tampil di semua layar --}}
                    <button id="hamburger-btn"
                            onclick="toggleSidebar()"
                            class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-gray-100 transition-colors"
                            aria-label="Toggle sidebar">
                        {{-- Icon lines (default) --}}
                        <svg id="hamburger-icon-open" class="w-5 h-5 text-zinc-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        {{-- Icon X (saat sidebar terbuka di desktop) --}}
                        <svg id="hamburger-icon-close" class="w-5 h-5 text-zinc-700 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <div class="flex items-center gap-2 px-3 py-1 bg-emerald-50 rounded-full border border-emerald-100">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full opacity-70 animate-pulse"></span>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-emerald-700">Live System</span>
                    </div>
                </div>

                {{-- Kanan: Notif Bell + Avatar --}}
                <div class="flex items-center gap-3 pl-4 border-l border-zinc-100">

                    {{-- ── Notification Bell ── --}}
                    <div class="relative">
                        <button id="notif-btn"
                                onclick="toggleNotif()"
                                class="w-9 h-9 rounded-2xl flex items-center justify-center hover:bg-gray-100 transition-colors relative"
                                aria-label="Notifications">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.67" viewBox="0 0 20 20">
                                <path d="M10 2a6 6 0 00-6 6v3.5L2.5 13.5h15L16 11.5V8a6 6 0 00-6-6z"/>
                                <path d="M8 15.5a2 2 0 004 0"/>
                            </svg>
                            {{-- Badge unread --}}
                            <span id="notif-badge"
                                  class="absolute top-1.5 right-1.5 w-2 h-2 bg-purple-600 rounded-full border-2 border-white transition-opacity">
                            </span>
                        </button>

                        {{-- ── Notification Panel ── --}}
                        <div id="notif-panel"
                             class="hidden absolute right-0 top-12 w-[22rem] bg-white rounded-[2rem]
                                    shadow-[0px_25px_50px_-12px_rgba(0,0,0,0.15)] border border-zinc-100 z-40 overflow-hidden">

                            {{-- Header --}}
                            <div class="h-14 px-5 bg-gray-50/30 border-b border-zinc-100 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-black uppercase tracking-wider text-zinc-900">Activity Feed</span>
                                    <span id="notif-count-badge"
                                          class="px-2 py-0.5 bg-purple-600 rounded-full text-[9px] font-black text-white">
                                        2 NEW
                                    </span>
                                </div>
                                <button onclick="markAllRead()"
                                        class="text-[9px] font-black uppercase tracking-wide text-purple-600 hover:text-purple-800 transition-colors">
                                    Mark all as read
                                </button>
                            </div>

                            {{-- Items --}}
                            <div id="notif-list" class="divide-y divide-zinc-100/60 max-h-[420px] overflow-y-auto">

                                {{-- Item 1: Unread --}}
                                <div class="notif-item relative flex gap-4 px-5 py-4 hover:bg-zinc-50/60 transition-colors cursor-pointer" data-read="false">
                                    <div class="notif-bar absolute left-0 top-0 bottom-0 w-1 bg-purple-600 rounded-r transition-all"></div>
                                    <div class="w-10 h-10 shrink-0 bg-emerald-50 rounded-2xl border border-emerald-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                                            <line x1="8" y1="1.33" x2="8" y2="14.67"/>
                                            <path d="M4 4.67a2.67 2.67 0 012.67-2.67H9.5"/>
                                            <path d="M4 11.33a2.67 2.67 0 002.67 2.67H10"/>
                                        </svg>
                                    </div>
                                    <div class="flex flex-col gap-1 flex-1 min-w-0">
                                        <div class="flex justify-between items-start gap-2">
                                            <span class="text-sm font-bold text-zinc-900 leading-tight">Salary Slip Released</span>
                                            <span class="text-[9px] font-black uppercase text-gray-400 tracking-wide whitespace-nowrap shrink-0">2 hours ago</span>
                                        </div>
                                        <p class="text-xs text-gray-500 leading-[1.6]">Your February 2026 statement is now available for download.</p>
                                        <span class="self-start mt-0.5 px-2 py-0.5 bg-rose-50 rounded text-[8px] font-black uppercase text-rose-600 tracking-wide">High Priority</span>
                                    </div>
                                </div>

                                {{-- Item 2: Unread --}}
                                <div class="notif-item relative flex gap-4 px-5 py-4 hover:bg-zinc-50/60 transition-colors cursor-pointer" data-read="false">
                                    <div class="notif-bar absolute left-0 top-0 bottom-0 w-1 bg-purple-600 rounded-r transition-all"></div>
                                    <div class="w-10 h-10 shrink-0 bg-purple-600/5 rounded-2xl border border-purple-600/10 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                                            <path d="M2.67 2.67h10.66v8H2.67z"/>
                                            <path d="M5.33 10.67v2.66M10.67 10.67v2.66M4 13.33h8"/>
                                        </svg>
                                    </div>
                                    <div class="flex flex-col gap-1 flex-1 min-w-0">
                                        <div class="flex justify-between items-start gap-2">
                                            <span class="text-sm font-bold text-zinc-900 leading-tight">New Menu Training</span>
                                            <span class="text-[9px] font-black uppercase text-gray-400 tracking-wide whitespace-nowrap shrink-0">4 hours ago</span>
                                        </div>
                                        <p class="text-xs text-gray-500 leading-[1.6]">Sarah posted a new update regarding Monday morning training.</p>
                                        <span class="self-start mt-0.5 px-2 py-0.5 bg-amber-50 rounded text-[8px] font-black uppercase text-amber-600 tracking-wide">Medium Priority</span>
                                    </div>
                                </div>

                                {{-- Item 3: Read --}}
                                <div class="notif-item relative flex gap-4 px-5 py-4 hover:bg-zinc-50/60 transition-colors cursor-pointer" data-read="true">
                                    <div class="w-10 h-10 shrink-0 bg-amber-50 rounded-2xl border border-amber-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                                            <rect x="1.33" y="3.33" width="13.33" height="9.33" rx="1"/>
                                            <path d="M1.33 6l6.67 4 6.67-4"/>
                                        </svg>
                                    </div>
                                    <div class="flex flex-col gap-1 flex-1 min-w-0">
                                        <div class="flex justify-between items-start gap-2">
                                            <span class="text-sm font-bold text-zinc-900/70 leading-tight">Monthly Review Open</span>
                                            <span class="text-[9px] font-black uppercase text-gray-400 tracking-wide whitespace-nowrap shrink-0">Yesterday</span>
                                        </div>
                                        <p class="text-xs text-gray-500 leading-[1.6]">The performance cycle for Feb 2026 is now accepting ratings.</p>
                                        <span class="self-start mt-0.5 px-2 py-0.5 bg-amber-50 rounded text-[8px] font-black uppercase text-amber-600 tracking-wide">Medium Priority</span>
                                    </div>
                                </div>

                                {{-- Item 4: Read --}}
                                <div class="notif-item relative flex gap-4 px-5 py-4 hover:bg-zinc-50/60 transition-colors cursor-pointer" data-read="true">
                                    <div class="w-10 h-10 shrink-0 bg-blue-50 rounded-2xl border border-blue-100 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                                            <rect x="2" y="2" width="12" height="12" rx="1.33"/>
                                            <path d="M8 5.33v3.34M8 10.67v.66"/>
                                        </svg>
                                    </div>
                                    <div class="flex flex-col gap-1 flex-1 min-w-0">
                                        <div class="flex justify-between items-start gap-2">
                                            <span class="text-sm font-bold text-zinc-900/70 leading-tight">Security Sync</span>
                                            <span class="text-[9px] font-black uppercase text-gray-400 tracking-wide whitespace-nowrap shrink-0">2 days ago</span>
                                        </div>
                                        <p class="text-xs text-gray-500 leading-[1.6]">Your account was successfully synced with the Identity Shield.</p>
                                        <span class="self-start mt-0.5 px-2 py-0.5 bg-zinc-100 rounded text-[8px] font-black uppercase text-zinc-500 tracking-wide">Low Priority</span>
                                    </div>
                                </div>

                            </div>

                            {{-- Footer --}}
                            <div class="h-12 border-t border-zinc-100 bg-gray-50/20 flex items-center justify-center">
                                <a href="#" class="text-[10px] font-black uppercase tracking-wide text-gray-400 hover:text-purple-600 transition-colors">
                                    View System Audit Log
                                </a>
                            </div>
                        </div>
                    </div>
                    {{-- ── End Notification ── --}}

                    {{-- Avatar --}}
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

    {{-- ===== SCRIPTS ===== --}}
    <script>
        // ─────────────────────────────────────
        // SIDEBAR TOGGLE
        // ─────────────────────────────────────
        const sidebar        = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const hamburgerOpen  = document.getElementById('hamburger-icon-open');
        const hamburgerClose = document.getElementById('hamburger-icon-close');

        // Default: sidebar TERTUTUP
        let sidebarOpen = false;

        function setSidebarState(open) {
            sidebarOpen = open;

            if (open) {
                // Buka sidebar → lebarkan jadi 256px → konten terdorong ke kanan
                sidebar.style.width = '16rem'; // w-64
                // Mobile: tampilkan overlay gelap
                if (window.innerWidth < 1024) {
                    sidebarOverlay.classList.remove('hidden');
                }
            } else {
                // Tutup sidebar → kempiskan ke 0
                sidebar.style.width = '0';
                sidebarOverlay.classList.add('hidden');
            }

            // Swap icon hamburger
            hamburgerOpen.classList.toggle('hidden', open);
            hamburgerClose.classList.toggle('hidden', !open);
        }

        function toggleSidebar() {
            setSidebarState(!sidebarOpen);
        }

        // Inisialisasi: sidebar tertutup saat load
        setSidebarState(false);

        // Mobile resize: tutup sidebar kalau layar mengecil
        window.addEventListener('resize', () => {
            if (window.innerWidth < 1024 && sidebarOpen) {
                sidebarOverlay.classList.remove('hidden');
            } else {
                sidebarOverlay.classList.add('hidden');
            }
        });

        // ─────────────────────────────────────
        // NOTIFICATION PANEL
        // ─────────────────────────────────────
        const notifPanel   = document.getElementById('notif-panel');
        const notifOverlay = document.getElementById('notif-overlay');
        const notifBadge   = document.getElementById('notif-badge');
        const notifCountBadge = document.getElementById('notif-count-badge');
        let notifOpen = false;

        function toggleNotif() {
            notifOpen = !notifOpen;
            notifPanel.classList.toggle('hidden', !notifOpen);
            notifOverlay.classList.toggle('hidden', !notifOpen);
        }

        function closeNotif() {
            notifOpen = false;
            notifPanel.classList.add('hidden');
            notifOverlay.classList.add('hidden');
        }

        // Klik di dalam panel tidak menutup
        notifPanel.addEventListener('click', e => e.stopPropagation());

        // Mark all as read
        function markAllRead() {
            const items = document.querySelectorAll('.notif-item');
            let unreadCount = 0;

            items.forEach(item => {
                if (item.dataset.read === 'false') {
                    item.dataset.read = 'true';
                    // Hapus purple bar
                    const bar = item.querySelector('.notif-bar');
                    if (bar) bar.remove();
                    // Redup judul
                    const title = item.querySelector('span.font-bold');
                    if (title) {
                        title.classList.remove('text-zinc-900');
                        title.classList.add('text-zinc-900/70');
                    }
                }
            });

            // Sembunyikan badge
            notifBadge.classList.add('opacity-0');
            notifCountBadge.classList.add('hidden');
        }

        // Klik item notif → tandai sebagai dibaca
        document.querySelectorAll('.notif-item').forEach(item => {
            item.addEventListener('click', () => {
                if (item.dataset.read === 'false') {
                    item.dataset.read = 'true';
                    const bar = item.querySelector('.notif-bar');
                    if (bar) bar.remove();
                    const title = item.querySelector('span.font-bold');
                    if (title) {
                        title.classList.remove('text-zinc-900');
                        title.classList.add('text-zinc-900/70');
                    }
                    // Update count badge
                    const unread = document.querySelectorAll('.notif-item[data-read="false"]').length;
                    if (unread === 0) {
                        notifBadge.classList.add('opacity-0');
                        notifCountBadge.classList.add('hidden');
                    } else {
                        notifCountBadge.textContent = unread + ' NEW';
                    }
                }
            });
        });
    </script>

    {{-- JS spesifik per-halaman — HARUS di sini agar DOM sudah siap --}}
    @stack('scripts')

</body>
</html>