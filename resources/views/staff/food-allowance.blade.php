@extends('layouts.app')
@section('title', 'Food Allowance & Cash Advance')

@push('styles')
<style>
    @keyframes slideUp {
        from { opacity:0; transform:translateY(20px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .modal-inner { animation: slideUp .22s cubic-bezier(.22,1,.36,1); }

    .menu-card:hover { border-color: #e9d5ff; background: rgba(147,51,234,.03); }
    .menu-card.selected { border-color: #9333ea; background: rgba(147,51,234,.06); }
    .menu-card.selected .card-badge { background: #9333ea; color: white; }

    input[type="date"]::-webkit-calendar-picker-indicator { opacity: 0.5; }

    /* Scrollbar thin */
    .scroll-thin::-webkit-scrollbar { width: 4px; }
    .scroll-thin::-webkit-scrollbar-track { background: transparent; }
    .scroll-thin::-webkit-scrollbar-thumb { background: #e4e4e7; border-radius: 4px; }

    /* Button state classes */
    .btn-kasbon-disabled { opacity:.3; cursor:not-allowed; pointer-events:none; }
    .btn-kasbon-active   { opacity:1; cursor:pointer; pointer-events:auto; box-shadow:0 10px 20px -4px rgba(147,51,234,.35); }
    .btn-kasbon-active:hover { filter:brightness(1.08); }
    .btn-cash-disabled   { opacity:.35; cursor:not-allowed; pointer-events:none; }
    .btn-cash-active     { opacity:1; cursor:pointer; pointer-events:auto; }
    .btn-cash-active:hover { filter:brightness(1.08); }
</style>
@endpush

@section('content')
@php
$menuItems = [
    ['id'=>1,  'name'=>'Nasi Goreng Special', 'cat'=>'Main',  'price'=>25000, 'color'=>'blue'],
    ['id'=>2,  'name'=>'Iced Americano',       'cat'=>'Drink', 'price'=>15000, 'color'=>'amber'],
    ['id'=>3,  'name'=>'Club Sandwich',        'cat'=>'Main',  'price'=>22000, 'color'=>'blue'],
    ['id'=>4,  'name'=>'Caesar Salad',         'cat'=>'Main',  'price'=>20000, 'color'=>'blue'],
    ['id'=>5,  'name'=>'Hot Latte',            'cat'=>'Drink', 'price'=>18000, 'color'=>'amber'],
    ['id'=>6,  'name'=>'Matcha Brownie',       'cat'=>'Snack', 'price'=>12000, 'color'=>'purple'],
    ['id'=>7,  'name'=>'Sweet Potato Fries',   'cat'=>'Snack', 'price'=>14000, 'color'=>'purple'],
    ['id'=>8,  'name'=>'Lemon Tea',            'cat'=>'Drink', 'price'=>10000, 'color'=>'amber'],
    ['id'=>9,  'name'=>'Chicken Rice Bowl',    'cat'=>'Main',  'price'=>28000, 'color'=>'blue'],
    ['id'=>10, 'name'=>'Es Teh Manis',         'cat'=>'Drink', 'price'=>8000,  'color'=>'amber'],
];

$recentActivity = [
    ['date'=>'Wed, Feb 11','type'=>'food',  'amount'=>37000,  'status'=>'approved','tags'=>['1x Nasi Goreng Special','1x Iced Americano']],
    ['date'=>'Tue, Feb 10','type'=>'food',  'amount'=>15000,  'status'=>'approved','tags'=>['1x Hot Latte']],
    ['date'=>'Mon, Feb 9', 'type'=>'food',  'amount'=>22000,  'status'=>'approved','tags'=>['1x Club Sandwich']],
    ['date'=>'Sun, Feb 8', 'type'=>'cash',  'amount'=>350000, 'status'=>'approved','note'=>'Motor service'],
    ['date'=>'Thu, Feb 5', 'type'=>'cash',  'amount'=>150000, 'status'=>'approved','note'=>'Medical expense'],
];

$allowanceLeft = 350000;
@endphp

<div class="min-h-screen bg-white">
<div class="px-6 lg:px-8 py-8 max-w-350">

{{-- ── PAGE HEADER ─────────────────────────────── --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 mb-10">
    <div>
        <div class="flex items-center gap-2 mb-2">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                <path d="M2 1.5h1.2v3A1.2 1.2 0 005.4 4.5V1.5H6.4" stroke="#9333ea" stroke-width="1.2" stroke-linecap="round"/>
                <path d="M4.2 4.5v8" stroke="#9333ea" stroke-width="1.2" stroke-linecap="round"/>
                <path d="M9.5 1.5v11M9.5 1.5a3 3 0 010 5.5" stroke="#9333ea" stroke-width="1.2" stroke-linecap="round"/>
            </svg>
            <span class="text-[10px] font-black uppercase tracking-[0.12em] text-purple-600">Employee Perks</span>
        </div>
        <h1 class="font-mono font-bold text-[28px] leading-tight text-zinc-900">Food Allowance & Cash Advance</h1>
        <p class="font-mono text-sm text-gray-400 mt-1 leading-6">Log daily meals or submit a cash advance. Click any history entry to view, edit, or delete it.</p>
    </div>

    <button onclick="openFoodKasbon()"
        class="flex items-center gap-5 px-7 py-5 rounded-[36px] shrink-0 cursor-pointer transition-all duration-200 hover:shadow-md active:scale-[.98] border-0"
        style="background:rgba(147,51,234,.05);outline:1px solid rgba(147,51,234,.12);box-shadow:0 1px 3px rgba(0,0,0,.06)">
        <div>
            <p class="text-[10px] font-black uppercase tracking-[.12em] text-purple-600/60 mb-0.5">Allowance Left</p>
            <p class="text-[22px] font-black text-zinc-900 tabular-nums leading-tight">{{ number_format($allowanceLeft, 0, ',', '.') }}</p>
        </div>
        <div class="w-12 h-12 bg-purple-600 rounded-[18px] flex items-center justify-center shrink-0"
             style="box-shadow:0 8px 16px -4px rgba(147,51,234,.35)">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M10 2v16M6.5 5a3.5 3.5 0 013.5-3h1.5" stroke="white" stroke-width="2" stroke-linecap="round"/>
                <path d="M6.5 15a3.5 3.5 0 003.5 3h1.5" stroke="white" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>
    </button>
</div>

{{-- ── MAIN LAYOUT ──────────────────────────────── --}}
<div class="flex flex-col xl:flex-row gap-6">

{{-- LEFT COLUMN --}}
<div class="flex-1 min-w-0 flex flex-col gap-6">

{{-- ── FOOD KASBON CARD ─────────────────────────── --}}
<div class="bg-white rounded-4xl border border-zinc-100 overflow-hidden" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">

    <div class="flex items-center gap-4 px-8 py-5 border-b border-zinc-100">
        <div class="w-9 h-9 bg-amber-50 rounded-2xl flex items-center justify-center shrink-0">
            <svg width="15" height="15" viewBox="0 0 14 14" fill="none">
                <path d="M2 1.5h1.2v3A1.2 1.2 0 005.4 4.5V1.5H6.4" stroke="#d97706" stroke-width="1.3" stroke-linecap="round"/>
                <path d="M4.2 4.5v8" stroke="#d97706" stroke-width="1.3" stroke-linecap="round"/>
                <path d="M9.5 1.5v11M9.5 1.5a3 3 0 010 5.5" stroke="#d97706" stroke-width="1.3" stroke-linecap="round"/>
            </svg>
        </div>
        <div>
            <p class="text-[11px] font-black uppercase tracking-wider text-zinc-900">Food Kasbon</p>
            <p class="text-[10px] text-gray-400 mt-0.5">Pick from the daily menu and submit your tray.</p>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row">

        {{-- Menu Grid --}}
        <div class="flex-1 p-6 border-b lg:border-b-0 lg:border-r border-zinc-100">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 gap-3 max-h-115 overflow-y-auto scroll-thin pr-0.5">
                @foreach($menuItems as $item)
                @php
                    $palettes = [
                        'blue'   => ['icon_bg'=>'bg-blue-50',   'stroke'=>'#2563eb'],
                        'amber'  => ['icon_bg'=>'bg-amber-50',  'stroke'=>'#d97706'],
                        'purple' => ['icon_bg'=>'bg-purple-50', 'stroke'=>'#9333ea'],
                    ];
                    $pal = $palettes[$item['color']];
                @endphp
                <div class="menu-card group relative bg-white rounded-[20px] border border-zinc-100 p-4 cursor-pointer transition-all duration-150 select-none"
                     data-id="{{ $item['id'] }}"
                     data-name="{{ $item['name'] }}"
                     data-price="{{ $item['price'] }}"
                     data-cat="{{ $item['cat'] }}"
                     data-color="{{ $item['color'] }}"
                     onclick="addToTray(this)">
                    <div class="flex items-start justify-between mb-3">
                        <div class="w-9 h-9 {{ $pal['icon_bg'] }} rounded-xl flex items-center justify-center shrink-0">
                            @if($item['color']==='amber')
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <path d="M3 2.5v1.2M6 2.5v1.2M9 2.5v1.2" stroke="{{ $pal['stroke'] }}" stroke-width="1.3" stroke-linecap="round"/>
                                <rect x="1.5" y="4.5" width="9" height="7" rx="1.5" stroke="{{ $pal['stroke'] }}" stroke-width="1.3" fill="none"/>
                            </svg>
                            @elseif($item['color']==='purple')
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <rect x="1.5" y="7" width="11" height="5.5" rx="1.5" stroke="{{ $pal['stroke'] }}" stroke-width="1.3" fill="none"/>
                                <path d="M4.5 7V5a3 3 0 016 0v2" stroke="{{ $pal['stroke'] }}" stroke-width="1.3" stroke-linecap="round" fill="none"/>
                            </svg>
                            @else
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                <circle cx="6.5" cy="6.5" r="4" stroke="{{ $pal['stroke'] }}" stroke-width="1.3" fill="none"/>
                                <circle cx="6.5" cy="6.5" r="1.5" stroke="{{ $pal['stroke'] }}" stroke-width="1.3" fill="none"/>
                                <path d="M10 10l2 2" stroke="{{ $pal['stroke'] }}" stroke-width="1.3" stroke-linecap="round"/>
                            </svg>
                            @endif
                        </div>
                        <span class="card-badge hidden text-[9px] font-black px-2 py-0.5 bg-zinc-100 text-zinc-500 rounded-full uppercase tracking-wide"></span>
                    </div>
                    <p class="text-[13px] font-black text-zinc-900 leading-5 mb-1">{{ $item['name'] }}</p>
                    <div class="flex items-center justify-between">
                        <p class="text-[9px] font-black uppercase tracking-widest text-gray-400">{{ $item['cat'] }}</p>
                        <p class="text-[12px] font-black text-zinc-500 tabular-nums">{{ number_format($item['price'],0,',','.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Entry Details Panel --}}
        <div class="w-full lg:w-72 xl:w-80 shrink-0 p-6 flex flex-col gap-5" style="background:rgba(250,250,252,.7)">
            <p class="text-[9px] font-black uppercase tracking-[.14em] text-zinc-400">Entry Details</p>

            {{-- Date input --}}
            <div>
                <label class="block text-[10px] font-black uppercase tracking-wide text-gray-400 mb-2">Select Date</label>
                <div class="relative">
                    <input type="date" id="kasbonDate"
                        class="w-full h-13 px-4 pl-10 bg-white border border-zinc-100 rounded-2xl text-sm font-bold text-zinc-900 focus:outline-none focus:border-purple-300 focus:ring-2 focus:ring-purple-100 transition"
                        style="height:52px">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-purple-500 pointer-events-none" fill="none" stroke="currentColor" stroke-width="1.4" viewBox="0 0 16 16">
                        <rect x="2" y="3" width="12" height="11" rx="1.5" fill="none"/>
                        <path d="M5 1.5v2M11 1.5v2M2 7h12" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>

            {{-- Tray --}}
            <div class="flex-1">
                <div class="flex items-center justify-between mb-3">
                    <label class="text-[10px] font-black uppercase tracking-wide text-gray-400">Your Tray</label>
                    <span id="trayBadge" class="px-2.5 py-1 bg-purple-600/10 rounded-full text-[9px] font-black uppercase tracking-wide text-purple-600">0 Items</span>
                </div>
                <div id="trayList" class="flex flex-col gap-2 min-h-25">
                    <div id="trayEmptyState" class="flex flex-col items-center justify-center h-24 opacity-20 gap-2">
                        <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
                            <rect x="6" y="9" width="24" height="20" rx="2" stroke="#18181b" stroke-width="2.5" fill="none"/>
                            <circle cx="18" cy="19" r="5" stroke="#18181b" stroke-width="2.5" fill="none"/>
                        </svg>
                        <p class="text-[9px] font-black uppercase tracking-widest text-zinc-900">Tray is empty</p>
                    </div>
                </div>
            </div>

            {{-- Total + Process button + Upload --}}
            <div class="border-t border-zinc-100 pt-4 flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-black uppercase tracking-wide text-gray-400">Log Amount</span>
                    <span id="trayTotal" class="text-2xl font-black text-purple-600 tabular-nums">00.000</span>
                </div>

                <button id="btnProcessKasbon" type="button" onclick="processKasbon()"
                    class="w-full flex items-center justify-center gap-2.5 rounded-3xl text-[11px] font-black uppercase tracking-widest text-white border-0 transition-all duration-200 btn-kasbon-disabled"
                    style="height:52px;background:#9333ea;">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <rect x="2" y="6" width="12" height="9" rx="1.5" stroke="white" stroke-width="1.5" fill="none"/>
                        <path d="M5 6V5a3 3 0 016 0v1" stroke="white" stroke-width="1.5" stroke-linecap="round" fill="none"/>
                        <circle cx="8" cy="10.5" r="1.5" fill="white"/>
                    </svg>
                    Process Kasbon
                </button>

                {{-- Upload Foto Bukti: label membungkus input file agar seluruh area bisa diklik --}}
                <label for="kasbonProofUpload"
                       class="group flex items-center gap-3 px-4 bg-gray-50 border-2 border-dashed border-zinc-200 rounded-2xl
                              cursor-pointer hover:border-purple-400 hover:bg-purple-50/20 transition-all duration-200"
                       style="height:52px">
                    <div class="w-8 h-8 bg-white rounded-xl shadow-sm flex items-center justify-center shrink-0 group-hover:shadow-md transition-shadow duration-200">
                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <circle cx="12" cy="12" r="3.5"/>
                            <path d="M8 5l1.5-2.5h5L16 5"/>
                            <circle cx="18" cy="7" r="1" fill="currentColor" stroke="none"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p id="kasbonProofName" class="text-xs font-black text-zinc-900 truncate">Upload Foto Struk</p>
                        <p id="kasbonProofHint" class="text-[9px] font-bold uppercase tracking-widest text-gray-400">JPG, PNG · Maks 5MB</p>
                    </div>
                    <input id="kasbonProofUpload" type="file" accept="image/jpeg,image/png" class="hidden"
                           onchange="handleKasbonProof(this)">
                </label>
            </div>

        </div>
    </div>
</div>{{-- end food kasbon card --}}

{{-- ── CASH ADVANCE CARD ────────────────────────── --}}
<div class="bg-white rounded-4xl border border-zinc-100 overflow-hidden" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">

    <div class="flex items-center gap-4 px-8 py-5 border-b border-zinc-100">
        <div class="w-9 h-9 bg-emerald-50 rounded-2xl flex items-center justify-center shrink-0">
            <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                <rect x="1.5" y="5.5" width="12" height="8" rx="1.5" stroke="#059669" stroke-width="1.3" fill="none"/>
                <path d="M5 5.5V4a2.5 2.5 0 015 0v1.5" stroke="#059669" stroke-width="1.3" stroke-linecap="round" fill="none"/>
                <circle cx="7.5" cy="9.5" r="1.3" fill="#059669"/>
            </svg>
        </div>
        <div>
            <p class="text-[11px] font-black uppercase tracking-wider text-zinc-900">Cash Advance Request</p>
            <p class="text-[10px] text-gray-400 mt-0.5">Submit a personal cash advance. Requires owner approval.</p>
        </div>
    </div>

    <div class="p-8 flex flex-col gap-6">
        <div class="flex flex-col sm:flex-row gap-5">
            <div class="flex-1">
                <label class="block text-[10px] font-black uppercase tracking-wide text-gray-400 mb-2">Purpose / Kebutuhan</label>
                <div class="relative">
                    <input type="text" id="cashPurpose" placeholder="e.g. Motor service, Medical, School fee"
                        class="w-full pl-10 pr-4 bg-gray-50/50 border border-zinc-100 rounded-2xl text-sm text-zinc-900 placeholder-zinc-300 focus:outline-none focus:border-purple-300 focus:ring-2 focus:ring-purple-100 transition"
                        style="height:52px">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-300 pointer-events-none" fill="none" stroke="currentColor" stroke-width="1.4" viewBox="0 0 16 16">
                        <path d="M2 13a1 1 0 011-1h10a1 1 0 011 1v1H2v-1z" fill="none"/>
                        <rect x="4" y="3" width="8" height="9" rx="1" fill="none"/>
                        <path d="M6 6h4M6 8h2" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
            <div class="sm:w-48">
                <label class="block text-[10px] font-black uppercase tracking-wide text-gray-400 mb-2">Amount (Rp)</label>
                <div class="relative">
                    <input type="number" id="cashAmount" placeholder="500000"
                        class="w-full pl-12 pr-4 bg-gray-50/50 border border-zinc-100 rounded-2xl text-sm font-black text-zinc-900 placeholder-zinc-300 focus:outline-none focus:border-purple-300 focus:ring-2 focus:ring-purple-100 transition"
                        style="height:52px">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[11px] font-black text-gray-300 pointer-events-none">Rp</span>
                </div>
            </div>
        </div>

        <div>
            <label class="block text-[10px] font-black uppercase tracking-wide text-gray-400 mb-2">Description / Keterangan</label>
            <div class="relative">
                <textarea id="cashDesc" rows="3" placeholder="Brief explanation for this cash advance request..."
                    class="w-full pl-10 pr-4 py-4 bg-gray-50/50 border border-zinc-100 rounded-2xl text-sm text-zinc-900 placeholder-zinc-300 focus:outline-none focus:border-purple-300 focus:ring-2 focus:ring-purple-100 transition resize-none"></textarea>
                <svg class="absolute left-3.5 top-4 w-4 h-4 text-gray-300 pointer-events-none" fill="none" stroke="currentColor" stroke-width="1.4" viewBox="0 0 16 16">
                    <rect x="3" y="2" width="7" height="9" rx="1" fill="none"/>
                    <path d="M5 5h3M5 7h5M5 9h2" stroke-linecap="round"/>
                </svg>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-2 px-4 h-10 bg-amber-50 rounded-2xl border border-amber-100 shrink-0">
                <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                    <circle cx="6.5" cy="6.5" r="5" stroke="#d97706" stroke-width="1.2" fill="none"/>
                    <path d="M6.5 4.5v2.5M6.5 9v.2" stroke="#d97706" stroke-width="1.2" stroke-linecap="round"/>
                </svg>
                <span class="text-[10px] font-bold text-amber-600">Pending owner approval after submission.</span>
            </div>
            <button id="btnSubmitCash" type="button" onclick="submitCashAdvance()"
                class="flex items-center gap-2 px-7 h-12 rounded-2xl text-[11px] font-black uppercase tracking-widest text-white border-0 transition-all duration-200 shrink-0 btn-cash-disabled"
                style="background:#059669;">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M2 7l3.5 3.5L12 3" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Submit Request
            </button>
        </div>
    </div>
</div>{{-- end cash advance --}}

</div>{{-- end left column --}}

{{-- ── RIGHT COLUMN — Recent Activity ─────────── --}}
<div class="xl:w-85 shrink-0 bg-white rounded-4xl border border-zinc-100 self-start sticky top-6" style="box-shadow:0 1px 3px rgba(0,0,0,.05)">

    <div class="flex items-center justify-between px-7 py-5 border-b border-zinc-100">
        <p class="text-[10px] font-black uppercase tracking-[.14em] text-zinc-400/70">Recent Activity</p>
        <div class="w-8 h-8 bg-gray-100 rounded-2xl flex items-center justify-center">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                <circle cx="6.5" cy="6.5" r="5" stroke="#9ca3af" stroke-width="1.2" fill="none"/>
                <circle cx="4" cy="4" r="1.3" stroke="#9ca3af" stroke-width="1.2" fill="none"/>
                <path d="M6.5 6.5l2 2" stroke="#9ca3af" stroke-width="1.2" stroke-linecap="round"/>
            </svg>
        </div>
    </div>
    <p class="px-7 py-2.5 text-[9px] font-black uppercase tracking-wide text-gray-300">Hover to edit · click to view details</p>

    <div class="px-7 py-4 flex flex-col gap-5">
        @foreach($recentActivity as $act)
        <div class="relative pl-6 border-l-2 {{ $act['type']==='cash' ? 'border-emerald-200' : 'border-purple-200' }} cursor-pointer hover:bg-zinc-50/60 -ml-px pr-2 py-1 rounded-r-2xl transition-colors group"
             data-payload="{{ json_encode($act, JSON_HEX_APOS|JSON_HEX_QUOT) }}"
             onclick="openEditEntry(JSON.parse(this.dataset.payload))">

            @if($act['type']==='cash')
            <div class="absolute -left-2.25 top-0.5 w-4 h-4 bg-emerald-100 rounded-full border-[3.5px] border-emerald-500"></div>
            @else
            <div class="absolute -left-2.25 top-0.5 w-4 h-4 bg-white rounded-full border-[3.5px] border-purple-600 shadow-sm"></div>
            @endif

            <div class="flex items-start justify-between mb-1.5">
                <div>
                    <p class="text-xs font-black text-zinc-900 leading-4">{{ $act['date'] }}</p>
                    @if($act['type']==='cash')
                    <p class="text-[10px] font-bold text-emerald-500 mt-0.5">⊡ Cash Advance</p>
                    @else
                    <p class="text-[10px] font-bold text-gray-400 mt-0.5">Food Kasbon</p>
                    @endif
                </div>
                <div class="text-right ml-3">
                    <p class="text-[13px] font-black {{ $act['type']==='cash' ? 'text-emerald-600' : 'text-purple-600' }} tabular-nums whitespace-nowrap">Rp {{ number_format($act['amount'],0,',','.') }}</p>
                    <span class="inline-block mt-0.5 px-2 py-0.5 bg-emerald-50 rounded-full text-[9px] font-black uppercase tracking-wide text-emerald-600">{{ $act['status'] }}</span>
                </div>
            </div>

            @if($act['type']==='food' && !empty($act['tags']))
            <div class="flex flex-wrap gap-1.5 mt-1">
                @foreach($act['tags'] as $tag)
                <span class="px-2 py-0.5 bg-gray-100 rounded-lg text-[9px] font-black uppercase tracking-wide text-gray-400">{{ $tag }}</span>
                @endforeach
            </div>
            @elseif($act['type']==='cash' && !empty($act['note']))
            <p class="text-[10px] font-semibold text-zinc-600/70 italic mt-0.5">"{{ $act['note'] }}"</p>
            @endif
        </div>
        @endforeach
    </div>

    <div class="px-7 pb-6">
        <div class="flex items-start gap-2.5 p-4 bg-amber-50 rounded-2xl border border-amber-100">
            <svg class="shrink-0 mt-0.5" width="13" height="13" viewBox="0 0 13 13" fill="none">
                <circle cx="6.5" cy="6.5" r="5" stroke="#d97706" stroke-width="1.2" fill="none"/>
                <path d="M6.5 4.5v2.5M6.5 9v.2" stroke="#d97706" stroke-width="1.2" stroke-linecap="round"/>
            </svg>
            <p class="text-[10px] font-bold text-amber-700 leading-normal">"All entries are cleared and deducted at the end of each payroll cycle."</p>
        </div>
    </div>
</div>{{-- end right column --}}

</div>{{-- end main flex --}}
</div>{{-- end page --}}
</div>

{{-- ══════════════════════════════════════════════
     MODAL 1: Food Kasbon
══════════════════════════════════════════════ --}}
<div id="modalFoodKasbon"
     style="display:none;position:fixed;inset:0;z-index:9998;align-items:center;justify-content:center;padding:1rem;background:rgba(0,0,0,.42);backdrop-filter:blur(7px);"
     onclick="if(event.target===this)closeFoodKasbon()">
    <div class="modal-inner bg-white rounded-4xl w-full max-w-lg overflow-hidden shadow-2xl">

        <div class="flex items-center justify-between px-7 pt-6 pb-5 border-b border-zinc-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-600/10 rounded-2xl flex items-center justify-center shrink-0">
                    <svg width="17" height="17" viewBox="0 0 14 14" fill="none">
                        <path d="M2 1.5h1.2v3A1.2 1.2 0 005.4 4.5V1.5H6.4" stroke="#9333ea" stroke-width="1.3" stroke-linecap="round"/>
                        <path d="M4.2 4.5v8" stroke="#9333ea" stroke-width="1.3" stroke-linecap="round"/>
                        <path d="M9.5 1.5v11M9.5 1.5a3 3 0 010 5.5" stroke="#9333ea" stroke-width="1.3" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Edit Entry</p>
                    <p class="text-[18px] font-bold text-zinc-900 leading-7">Food Kasbon</p>
                </div>
            </div>
            <button type="button" onclick="closeFoodKasbon()"
                style="background:transparent;border:0;cursor:pointer"
                class="w-9 h-9 flex items-center justify-center rounded-2xl hover:bg-zinc-100 text-gray-400 transition-colors">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <line x1="2.5" y1="2.5" x2="11.5" y2="11.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                    <line x1="11.5" y1="2.5" x2="2.5" y2="11.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
            </button>
        </div>

        <div class="px-7 py-6 flex flex-col gap-5">

            <div>
                <label class="block text-[10px] font-black uppercase tracking-wide text-gray-400 mb-2">Date</label>
                <div class="relative">
                    <input type="date" id="modalKasbonDate"
                        class="w-full pl-10 pr-4 bg-gray-50/50 border border-zinc-100 rounded-2xl text-sm font-bold text-zinc-900 focus:outline-none focus:border-purple-300 focus:ring-2 focus:ring-purple-100 transition"
                        style="height:48px">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-purple-400 opacity-70 pointer-events-none" fill="none" stroke="currentColor" stroke-width="1.4" viewBox="0 0 16 16">
                        <rect x="2" y="3" width="12" height="11" rx="1.5" fill="none"/>
                        <path d="M5 1.5v2M11 1.5v2M2 7h12" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-wide text-gray-400 mb-3">Items</label>
                <div id="modalTrayList" class="flex flex-col gap-2 mb-3 min-h-12">
                    <p id="modalEmptyNote" class="text-[11px] text-gray-300 italic text-center py-3">No items yet — pick from menu below.</p>
                </div>
                <div class="flex items-center justify-between px-4 rounded-2xl border border-purple-100" style="height:48px;background:rgba(147,51,234,.04)">
                    <span class="text-[10px] font-black uppercase tracking-wide text-purple-600/60">New Total</span>
                    <span id="modalKasbonTotal" class="text-[15px] font-black text-purple-600 tabular-nums">0</span>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-wide text-gray-400 mb-2">Add Item</label>
                <div class="flex flex-wrap gap-1.5 max-h-28 overflow-y-auto scroll-thin">
                    @foreach($menuItems as $item)
                    <button type="button" 
                        data-id="{{ $item['id'] }}" 
                        data-name="{{ $item['name'] }}" 
                        data-price="{{ $item['price'] }}"
                        onclick="modalAddItem(this.dataset.id, this.dataset.name, parseInt(this.dataset.price))"
                        class="px-3 py-1.5 bg-gray-100 hover:bg-purple-50 hover:text-purple-700 rounded-xl text-[9px] font-black uppercase tracking-wide text-gray-500 border-0 cursor-pointer transition-colors">
                        {{ $item['name'] }}
                    </button>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-3 pt-1">
                <button type="button" onclick="closeFoodKasbon()"
                    style="background:#f4f4f5;border:1px solid #e4e4e7;cursor:pointer;height:44px;padding:0 24px;border-radius:14px;font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:.08em;color:#18181b">Back</button>
                <button type="button" onclick="saveKasbonModal()"
                    style="background:#9333ea;border:0;cursor:pointer;flex:1;height:44px;box-shadow:0 4px 12px -2px rgba(147,51,234,.3);border-radius:14px;font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:.08em;color:white"
                    class="flex items-center justify-center gap-2 hover:brightness-110 transition">
                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                        <path d="M1.5 6.5l3.5 3.5 6.5-6.5" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════
     MODAL 2: Edit Entry (from Recent Activity)
══════════════════════════════════════════════ --}}
<div id="modalEditEntry"
     style="display:none;position:fixed;inset:0;z-index:9998;align-items:center;justify-content:center;padding:1rem;background:rgba(0,0,0,.42);backdrop-filter:blur(7px);"
     onclick="if(event.target===this)closeEditEntry()">
    <div class="modal-inner bg-white rounded-4xl w-full max-w-md overflow-hidden shadow-2xl">
        <div class="flex items-center justify-between px-7 pt-6 pb-5 border-b border-zinc-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-600/10 rounded-2xl flex items-center justify-center shrink-0">
                    <svg width="17" height="17" viewBox="0 0 14 14" fill="none">
                        <path d="M2 1.5h1.2v3A1.2 1.2 0 005.4 4.5V1.5H6.4" stroke="#9333ea" stroke-width="1.3" stroke-linecap="round"/>
                        <path d="M4.2 4.5v8" stroke="#9333ea" stroke-width="1.3" stroke-linecap="round"/>
                        <path d="M9.5 1.5v11M9.5 1.5a3 3 0 010 5.5" stroke="#9333ea" stroke-width="1.3" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Edit Entry</p>
                    <p id="editModalTitle" class="text-[18px] font-bold text-zinc-900 leading-7">Food Kasbon</p>
                </div>
            </div>
            <button type="button" onclick="closeEditEntry()"
                style="background:transparent;border:0;cursor:pointer"
                class="w-9 h-9 flex items-center justify-center rounded-2xl hover:bg-zinc-100 text-gray-400 transition-colors">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <line x1="2.5" y1="2.5" x2="11.5" y2="11.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                    <line x1="11.5" y1="2.5" x2="2.5" y2="11.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
            </button>
        </div>
        <div id="editModalBody" class="px-7 py-6"></div>
    </div>
</div>

@endsection

@push('scripts')
<script>
/* ── helpers ─────────────────────────── */
function idr(n){ return Number(n).toLocaleString('id-ID'); }

/* ══════════════════════════════════════════
   MAIN PAGE TRAY
══════════════════════════════════════════ */
var tray = {};

function addToTray(el) {
    var id    = el.dataset.id;
    var name  = el.dataset.name;
    var price = parseInt(el.dataset.price);
    var color = el.dataset.color;
    if (tray[id]) {
        tray[id].qty++;
    } else {
        tray[id] = { name: name, price: price, qty: 1, color: color };
    }
    renderTray();
    el.classList.add('selected');
    var badge = el.querySelector('.card-badge');
    badge.textContent = 'x' + tray[id].qty;
    badge.classList.remove('hidden');
}

function renderTray() {
    var keys  = Object.keys(tray);
    var total = 0;
    var html  = '';
    keys.forEach(function(id) {
        var it = tray[id];
        total += it.price * it.qty;
        html +=
        '<div class="flex items-center gap-2 px-3 py-2 bg-white rounded-xl border border-zinc-100">' +
          '<span class="text-xs font-bold text-zinc-900 flex-1 truncate">' + it.name + '</span>' +
          '<button type="button" onclick="changeTrayQty(\'' + id + '\',-1)" style="background:#f4f4f5;border:0;cursor:pointer;width:24px;height:24px;border-radius:8px;font-weight:900;font-size:14px;line-height:1">&#8722;</button>' +
          '<span class="text-xs font-black w-5 text-center tabular-nums">' + it.qty + '</span>' +
          '<button type="button" onclick="changeTrayQty(\'' + id + '\',1)" style="background:#f4f4f5;border:0;cursor:pointer;width:24px;height:24px;border-radius:8px;font-weight:900;font-size:14px;line-height:1">+</button>' +
          '<span class="text-xs font-black text-purple-600 w-16 text-right tabular-nums">' + idr(it.price * it.qty) + '</span>' +
        '</div>';
    });

    var emEl   = document.getElementById('trayEmptyState');
    var listEl = document.getElementById('trayList');
    var badge  = document.getElementById('trayBadge');
    var totEl  = document.getElementById('trayTotal');
    var btn    = document.getElementById('btnProcessKasbon');

    if (keys.length) {
        listEl.innerHTML = html;
    } else {
        listEl.innerHTML = '';
        listEl.appendChild(emEl);
        emEl.style.display = 'flex';
    }

    var totalQty = keys.reduce(function(s, id){ return s + tray[id].qty; }, 0);
    badge.textContent = totalQty + ' Item' + (totalQty !== 1 ? 's' : '');
    totEl.textContent = idr(total);

    /* ── Toggle state tombol Process Kasbon via class ── */
    if (keys.length && total > 0) {
        btn.classList.remove('btn-kasbon-disabled');
        btn.classList.add('btn-kasbon-active');
    } else {
        btn.classList.remove('btn-kasbon-active');
        btn.classList.add('btn-kasbon-disabled');
    }
}

function changeTrayQty(id, delta) {
    if (!tray[id]) return;
    tray[id].qty += delta;
    if (tray[id].qty <= 0) {
        delete tray[id];
        var card = document.querySelector('[data-id="' + id + '"]');
        if (card) {
            card.classList.remove('selected');
            var b = card.querySelector('.card-badge');
            if (b) b.classList.add('hidden');
        }
    } else {
        var card = document.querySelector('[data-id="' + id + '"]');
        if (card) {
            var b = card.querySelector('.card-badge');
            if (b) b.textContent = 'x' + tray[id].qty;
        }
    }
    renderTray();
}

function processKasbon() {
    var date = document.getElementById('kasbonDate').value;
    if (!date) { alert('Please select a date first.'); return; }
    var keys = Object.keys(tray);
    if (!keys.length) return;
    alert('Kasbon submitted! ✓\n(dummy — connect to backend)');
    tray = {};
    document.querySelectorAll('.menu-card').forEach(function(c) {
        c.classList.remove('selected');
        var b = c.querySelector('.card-badge');
        if (b) { b.classList.add('hidden'); b.textContent = ''; }
    });
    renderTray();
    document.getElementById('kasbonDate').value = '';
    /* Reset upload foto */
    document.getElementById('kasbonProofUpload').value = '';
    document.getElementById('kasbonProofName').textContent = 'Upload Foto Struk';
    document.getElementById('kasbonProofName').style.color = '';
    document.getElementById('kasbonProofHint').textContent = 'JPG, PNG · Maks 5MB';
    document.getElementById('kasbonProofHint').style.color = '';
}

/* ══════════════════════════════════════════
   Upload foto bukti (struk)
══════════════════════════════════════════ */
function handleKasbonProof(input) {
    var file    = input.files && input.files[0];
    var nameEl  = document.getElementById('kasbonProofName');
    var hintEl  = document.getElementById('kasbonProofHint');
    if (!file) return;
    if (file.size > 5 * 1024 * 1024) {
        alert('Ukuran file melebihi 5MB.');
        input.value = '';
        return;
    }
    nameEl.textContent = file.name;
    nameEl.style.color = '#059669';
    hintEl.textContent = 'File terpilih ✓';
    hintEl.style.color = '#6ee7b7';
}

/* ══════════════════════════════════════════
   CASH ADVANCE
══════════════════════════════════════════ */
function _checkCash() {
    var ok  = document.getElementById('cashPurpose').value.trim() &&
              document.getElementById('cashAmount').value.trim();
    var btn = document.getElementById('btnSubmitCash');
    if (ok) {
        btn.classList.remove('btn-cash-disabled');
        btn.classList.add('btn-cash-active');
    } else {
        btn.classList.remove('btn-cash-active');
        btn.classList.add('btn-cash-disabled');
    }
}
document.getElementById('cashPurpose').addEventListener('input', _checkCash);
document.getElementById('cashAmount').addEventListener('input', _checkCash);

function submitCashAdvance() {
    var p = document.getElementById('cashPurpose').value.trim();
    var a = document.getElementById('cashAmount').value.trim();
    if (!p || !a) return;
    alert('Cash advance submitted for Rp ' + parseInt(a).toLocaleString('id-ID') + '! ✓\n(dummy — connect to backend)');
    document.getElementById('cashPurpose').value = '';
    document.getElementById('cashAmount').value  = '';
    document.getElementById('cashDesc').value    = '';
    _checkCash();
}

/* ══════════════════════════════════════════
   MODAL 1: Food Kasbon (via Allowance Left)
══════════════════════════════════════════ */
var mTray = {};

function openFoodKasbon() {
    mTray = {};
    _renderModalTray();
    document.getElementById('modalKasbonDate').value = new Date().toISOString().slice(0,10);
    document.getElementById('modalFoodKasbon').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeFoodKasbon() {
    document.getElementById('modalFoodKasbon').style.display = 'none';
    document.body.style.overflow = '';
}

function modalAddItem(id, name, price) {
    id = String(id);
    if (mTray[id]) { mTray[id].qty++; }
    else           { mTray[id] = { name: name, price: price, qty: 1 }; }
    _renderModalTray();
}

function _renderModalTray() {
    var keys  = Object.keys(mTray);
    var total = 0;
    var html  = '';
    keys.forEach(function(id) {
        var it = mTray[id];
        total += it.price * it.qty;
        html +=
        '<div class="flex items-center gap-2 px-3 py-2 bg-gray-50 rounded-xl border border-zinc-100">' +
          '<span class="text-xs font-bold text-zinc-900 flex-1">' + it.name + '</span>' +
          '<button type="button" onclick="changeModalQty(\'' + id + '\',-1)" style="background:#e5e7eb;border:0;cursor:pointer;width:22px;height:22px;border-radius:7px;font-weight:900;font-size:14px;line-height:1">&#8722;</button>' +
          '<span class="text-xs font-black w-5 text-center">' + it.qty + '</span>' +
          '<button type="button" onclick="changeModalQty(\'' + id + '\',1)" style="background:#e5e7eb;border:0;cursor:pointer;width:22px;height:22px;border-radius:7px;font-weight:900;font-size:14px;line-height:1">+</button>' +
          '<span class="text-xs font-black text-purple-600 w-14 text-right tabular-nums">' + idr(it.price * it.qty) + '</span>' +
          '<button type="button" onclick="changeModalQty(\'' + id + '\',-999)" style="background:transparent;border:0;cursor:pointer;color:#d1d5db;font-size:14px;line-height:1;margin-left:2px">&#x2715;</button>' +
        '</div>';
    });

    var emNote = document.getElementById('modalEmptyNote');
    var list   = document.getElementById('modalTrayList');
    emNote.style.display = keys.length ? 'none' : 'block';
    list.innerHTML = html;
    if (!keys.length) list.appendChild(emNote);
    document.getElementById('modalKasbonTotal').textContent = idr(total);
}

function changeModalQty(id, delta) {
    if (!mTray[id]) return;
    mTray[id].qty = Math.max(0, mTray[id].qty + delta);
    if (mTray[id].qty === 0) delete mTray[id];
    _renderModalTray();
}

function saveKasbonModal() {
    var date = document.getElementById('modalKasbonDate').value;
    if (!date)                       { alert('Please select a date.'); return; }
    if (!Object.keys(mTray).length)  { alert('Tray is empty.');        return; }
    alert('Kasbon saved! ✓\n(dummy — connect to backend)');
    closeFoodKasbon();
}

/* ══════════════════════════════════════════
   MODAL 2: Edit Entry (Recent Activity)
══════════════════════════════════════════ */
function openEditEntry(data) {
    document.getElementById('editModalTitle').textContent =
        data.type === 'cash' ? 'Cash Advance' : 'Food Kasbon';

    var body = '<div class="flex flex-col gap-4">';
    body += '<div><p class="text-[10px] font-black uppercase tracking-wide text-gray-400 mb-1">Date</p>' +
            '<p class="text-sm font-bold text-zinc-900">' + data.date + '</p></div>';

    if (data.type === 'food') {
        body += '<div><p class="text-[10px] font-black uppercase tracking-wide text-gray-400 mb-2">Items</p><div class="flex flex-col gap-2">';
        if (data.tags) {
            data.tags.forEach(function(tag) {
                body += '<div class="flex items-center justify-between px-3 py-2 bg-gray-50 rounded-xl border border-zinc-100">' +
                        '<span class="text-xs font-bold text-zinc-900">' + tag + '</span></div>';
            });
        }
        body += '</div></div>';
        body += '<div class="flex items-center justify-between px-4 rounded-2xl border border-purple-100" style="height:48px;background:rgba(147,51,234,.04)">' +
                '<span class="text-[10px] font-black uppercase tracking-wide text-purple-600/60">Total</span>' +
                '<span class="text-[15px] font-black text-purple-600 tabular-nums">Rp ' + idr(data.amount) + '</span></div>';
    } else {
        if (data.note) {
            body += '<div><p class="text-[10px] font-black uppercase tracking-wide text-gray-400 mb-1">Note</p>' +
                    '<p class="text-sm font-bold text-zinc-900">' + data.note + '</p></div>';
        }
        body += '<div><p class="text-[10px] font-black uppercase tracking-wide text-gray-400 mb-1">Amount</p>' +
                '<p class="text-2xl font-black text-emerald-600 tabular-nums">Rp ' + idr(data.amount) + '</p></div>';
    }

    body += '<div class="flex gap-3 pt-2">' +
            '<button type="button" onclick="closeEditEntry()" style="background:#f4f4f5;border:1px solid #e4e4e7;cursor:pointer;padding:0 24px;height:44px;border-radius:14px;font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:.08em;color:#18181b">Back</button>' +
            '<button type="button" onclick="closeEditEntry()" style="background:#9333ea;border:0;cursor:pointer;flex:1;height:44px;border-radius:14px;font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:.08em;color:white;box-shadow:0 4px 12px -2px rgba(147,51,234,.3)">Save Changes</button>' +
            '</div></div>';

    document.getElementById('editModalBody').innerHTML = body;
    document.getElementById('modalEditEntry').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeEditEntry() {
    document.getElementById('modalEditEntry').style.display = 'none';
    document.body.style.overflow = '';
}

/* ── ESC key ─────────────────────────── */
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { closeFoodKasbon(); closeEditEntry(); }
});
</script>
@endpush