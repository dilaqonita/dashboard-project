@extends('layouts.app')
@section('title', 'Staff Evaluations – Poly Games Cafe')

@section('content')

<div class="p-6 lg:p-8 w-full min-w-0">

{{-- PAGE HEADER --}}
<div class="mb-7">
    <div class="flex items-center gap-2 mb-1">
        <svg class="w-4 h-4 shrink-0" viewBox="0 0 16 16" fill="none">
            <circle cx="8" cy="5.33" r="2.67" stroke="#9333ea" stroke-width="1.33" fill="none"/>
            <path d="M2.67 13.33a5.33 5.33 0 0110.67 0" stroke="#9333ea" stroke-width="1.33" stroke-linecap="round" fill="none"/>
        </svg>
        <span class="text-[10px] font-bold uppercase tracking-widest text-purple-600">Performance Portal</span>
    </div>
    <h1 class="font-mono font-bold text-3xl text-zinc-900 leading-tight">Staff Evaluations</h1>
    <p class="font-mono text-sm text-gray-400 mt-1 max-w-lg leading-relaxed">
        Anonymous performance auditing on a 10-100 scale. Collective evaluation mode ensures team-wide consistency.
    </p>
</div>

{{-- HERO ROW --}}
<div class="flex flex-col lg:flex-row rounded-3xl overflow-hidden mb-6"
     style="box-shadow:0 16px 40px -10px rgba(147,51,234,.22);">
    <div class="flex-1 bg-purple-600 flex items-center justify-between px-8 py-8 gap-6 min-w-0">
        <div class="min-w-0">
            <p class="text-[10px] font-black uppercase tracking-widest mb-3 flex items-center gap-2"
                style="color:rgba(255,255,255,.65);">
                System Performance Index
                <svg width="12" height="12" viewBox="0 0 13 13" fill="none" class="shrink-0">
                    <path d="M6.5 1l1.18 2.38 2.63.38-1.9 1.85.45 2.62L6.5 7l-2.36 1.23.45-2.62L2.7 3.76l2.63-.38L6.5 1z"
                          stroke="#fbbf24" stroke-width="1.1" fill="none"/>
                </svg>
            </p>
            <div class="flex items-baseline gap-2">
                <span class="font-mono font-black text-white leading-none text-5xl sm:text-6xl">88.1</span>
                <span class="text-sm font-bold" style="color:rgba(255,255,255,.55);">/ 100</span>
            </div>
        </div>
        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-3xl flex items-center justify-center shrink-0"
             style="background:rgba(255,255,255,.12);">
            <svg width="36" height="36" viewBox="0 0 38 38" fill="none">
                <circle cx="19" cy="19" r="16" stroke="white" stroke-width="2.2" fill="none"/>
                <circle cx="19" cy="19" r="10" stroke="white" stroke-width="2.2" fill="none"/>
                <circle cx="19" cy="19" r="4"  stroke="white" stroke-width="2.2" fill="none"/>
            </svg>
        </div>
    </div>
    <div class="lg:w-96 shrink-0 bg-amber-50 border-t lg:border-t-0 lg:border-l border-amber-100
                flex items-center justify-between px-8 py-8 gap-4">
        <div class="min-w-0">
            <p class="text-[10px] font-black uppercase tracking-widest mb-2" style="color:rgba(217,119,6,.60);">Cycle Requirement</p>
            <p class="text-xl sm:text-2xl font-black uppercase text-amber-600 leading-tight mb-2">Mandatory Action</p>
            <p class="text-[10px] font-semibold leading-5 max-w-xs" style="color:rgba(217,119,6,.75);">
                Complete all ratings before the Feb 2026 payroll cycle concludes.
            </p>
        </div>
        <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center shrink-0">
            <svg width="26" height="26" viewBox="0 0 28 28" fill="none">
                <rect x="4" y="10" width="20" height="14" rx="2" stroke="#d97706" stroke-width="2.2" fill="none"/>
                <path d="M9 10V7a5 5 0 0110 0v3" stroke="#d97706" stroke-width="2.2" stroke-linecap="round" fill="none"/>
                <circle cx="14" cy="17" r="2.2" fill="#d97706"/>
            </svg>
        </div>
    </div>
</div>

{{-- FILTER BAR --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4
            px-6 py-4 bg-white rounded-3xl border border-zinc-100 shadow-sm mb-6">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 bg-purple-50 rounded-xl flex items-center justify-center shrink-0">
            <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                <path d="M1.5 3.75h12M3.5 7.5h8M5.5 11.25h4" stroke="#9333ea" stroke-width="1.4" stroke-linecap="round"/>
            </svg>
        </div>
        <div>
            <p class="text-[11px] font-black uppercase tracking-widest text-zinc-900">Filter View</p>
            <p class="text-[10px] text-gray-400 mt-0.5">Isolate performance by organizational role.</p>
        </div>
    </div>
    <div class="flex p-1 bg-gray-100 rounded-2xl gap-0.5 self-start sm:self-auto">
        <button onclick="setFilter(this,'all')"
                class="filter-tab is-active px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border-0 cursor-pointer transition-all">All</button>
        <button onclick="setFilter(this,'owner')"
                class="filter-tab px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border-0 cursor-pointer transition-all">Owner</button>
        <button onclick="setFilter(this,'staff')"
                class="filter-tab px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest border-0 cursor-pointer transition-all">Staff</button>
    </div>
</div>

{{-- SCOREBOARD --}}
<div id="viewScoreboard" class="bg-white rounded-3xl border border-zinc-100 shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-6 sm:px-8 h-16 border-b border-zinc-100 bg-gray-50/40">
        <span class="text-[10px] font-black uppercase tracking-widest text-zinc-400">Confidential Scoreboard</span>
        <div class="flex items-center gap-2 px-3 h-7 bg-white rounded-xl border border-zinc-100">
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                <path d="M6.5 1.5L2 3.3v3.7c0 2.7 2.1 4.8 4.5 5 2.4-.2 4.5-2.3 4.5-5V3.3L6.5 1.5z" stroke="#9ca3af" stroke-width="1.1" fill="none"/>
                <line x1="4" y1="6" x2="9" y2="6" stroke="#9ca3af" stroke-width="1.1" stroke-linecap="round"/>
                <line x1="6.5" y1="3.5" x2="6.5" y2="8.5" stroke="#9ca3af" stroke-width="1.1" stroke-linecap="round"/>
            </svg>
            <span class="text-[9px] font-black uppercase tracking-widest text-gray-400 hidden sm:block">Identity Shield Active</span>
        </div>
    </div>
    <div class="hidden md:grid border-b border-zinc-100 bg-gray-50/10"
         style="grid-template-columns:2.5fr 1fr 2fr 1fr 120px;">
        <div class="px-8 py-4 text-[9px] font-black uppercase tracking-widest text-gray-400">Entity</div>
        <div class="px-4 py-4 text-[9px] font-black uppercase tracking-widest text-gray-400">Role</div>
        <div class="px-4 py-4 text-[9px] font-black uppercase tracking-widest text-gray-400">Avg (100)</div>
        <div class="px-4 py-4 text-[9px] font-black uppercase tracking-widest text-gray-400">Responses</div>
        <div class="px-6 py-4 text-[9px] font-black uppercase tracking-widest text-gray-400 text-right">Actions</div>
    </div>

    @php
    $staffList = [
        ['name'=>'Sarah Anderson',  'role'=>'owner',       'score'=>88, 'resp'=>'18 / 24', 'img'=>'https://i.pravatar.cc/40?img=47'],
        ['name'=>'Marcus Thorne',   'role'=>'owner',       'score'=>92, 'resp'=>'15 / 24', 'img'=>'https://i.pravatar.cc/40?img=12'],
        ['name'=>'Elena Vance',     'role'=>'owner',       'score'=>85, 'resp'=>'12 / 24', 'img'=>'https://i.pravatar.cc/40?img=45'],
        ['name'=>'John Martinez',   'role'=>'barista',     'score'=>84, 'resp'=>'5 / 12',  'img'=>'https://i.pravatar.cc/40?img=33'],
        ['name'=>'Emily Taylor',    'role'=>'barista',     'score'=>96, 'resp'=>'12 / 12', 'img'=>'https://i.pravatar.cc/40?img=48'],
        ['name'=>'Michael Wong',    'role'=>'barista',     'score'=>78, 'resp'=>'8 / 12',  'img'=>'https://i.pravatar.cc/40?img=15'],
        ['name'=>'Alex Chen',       'role'=>'game master', 'score'=>92, 'resp'=>'2 / 12',  'img'=>'https://i.pravatar.cc/40?img=7'],
        ['name'=>'Sofia Rodriguez', 'role'=>'game master', 'score'=>88, 'resp'=>'10 / 12', 'img'=>'https://i.pravatar.cc/40?img=49'],
        ['name'=>'Liam OConnor',    'role'=>'game master', 'score'=>90, 'resp'=>'12 / 12', 'img'=>'https://i.pravatar.cc/40?img=3'],
    ];
    @endphp

    @foreach($staffList as $p)
    @php
        $group    = $p['role'] === 'owner' ? 'owner' : 'staff';
        $words    = explode(' ', $p['name']);
        $initials = strtoupper(substr($words[0],0,1)) . (isset($words[1]) ? strtoupper(substr($words[1],0,1)) : '');
        $hits     = (int) trim(explode('/', $p['resp'])[0]);
        $dataJson = json_encode(['name'=>$p['name'],'role'=>$p['role'],'score'=>$p['score'],'hits'=>$hits], JSON_HEX_APOS|JSON_HEX_QUOT);
    @endphp
    <div class="staff-row hover:bg-purple-50/20 transition-colors duration-150 border-b border-zinc-100/50 last:border-b-0"
         data-group="{{ $group }}">
        {{-- Mobile --}}
        <div class="flex items-center justify-between px-5 py-4 gap-3 md:hidden">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-xl overflow-hidden shrink-0 bg-zinc-100">
                    <img src="{{ $p['img'] }}" alt="" class="w-full h-full object-cover">
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-zinc-900 truncate">{{ $p['name'] }}</p>
                    <p class="text-[9px] font-black uppercase tracking-widest text-gray-400">{{ $p['role'] }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <span class="text-xl font-black text-purple-600 tabular-nums">{{ $p['score'] }}</span>
                <button data-payload="{{ $dataJson }}"
                        onclick="handleAnalyze(JSON.parse(this.dataset.payload))"
                        class="px-3 py-2 bg-gray-100 hover:bg-zinc-200 rounded-xl text-[9px] font-black uppercase tracking-widest text-zinc-700 transition-colors border-0 cursor-pointer">
                    Analyze
                </button>
            </div>
        </div>
        {{-- Desktop --}}
        <div class="hidden md:grid items-center min-h-20"
             style="grid-template-columns:2.5fr 1fr 2fr 1fr 120px;">
            <div class="px-8 flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-xl overflow-hidden shrink-0 bg-zinc-100">
                    <img src="{{ $p['img'] }}" alt="" class="w-full h-full object-cover">
                </div>
                <span class="text-sm font-bold text-zinc-900 truncate">{{ $p['name'] }}</span>
            </div>
            <div class="px-4">
                <span class="inline-flex items-center px-3 py-1 bg-gray-100 rounded-xl text-[9px] font-black uppercase tracking-widest text-gray-500 whitespace-nowrap">
                    {{ $p['role'] }}
                </span>
            </div>
            <div class="px-4 flex items-center gap-3">
                <span class="text-lg font-black text-purple-600 w-9 tabular-nums leading-none shrink-0">{{ $p['score'] }}</span>
                <div class="flex-1 max-w-32 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    {{-- FIX PAMUNGKAS: Menggunakan Laravel @style directive! --}}
                    <div class="h-full bg-purple-600 rounded-full" @style(["width: {$p['score']}%"])></div>
                </div>
            </div>
            <div class="px-4">
                <span class="text-[10px] font-black tabular-nums text-gray-300 whitespace-nowrap">{{ $p['resp'] }}</span>
            </div>
            <div class="px-6 flex justify-end">
                <button data-payload="{{ $dataJson }}"
                        onclick="handleAnalyze(JSON.parse(this.dataset.payload))"
                        class="px-4 py-2 bg-gray-100 hover:bg-zinc-200 rounded-xl text-[9px] font-black uppercase tracking-widest text-zinc-700 transition-colors border-0 cursor-pointer whitespace-nowrap">
                    Analyze
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- AUDIT VIEW --}}
<div id="viewAudit" style="display:none;">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4
                px-6 py-4 bg-purple-50 rounded-3xl border border-purple-100 mb-6">
        <div class="flex items-center gap-3">
            <button onclick="closeAudit()"
                    class="w-9 h-9 bg-white rounded-xl border border-purple-100 flex items-center justify-center hover:bg-purple-100 transition-colors cursor-pointer shrink-0">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M10 3L6 8l4 5" stroke="#9333ea" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <div>
                <p id="auditName" class="text-base font-black text-purple-600 leading-5">Active Management Audit</p>
                <p class="text-[9px] font-bold uppercase tracking-widest text-purple-400 mt-0.5">Anonymous Owner Review · Scale: 10-100</p>
            </div>
        </div>
        <div class="flex items-center gap-2 px-3 h-7 bg-white rounded-xl border border-purple-100 self-start sm:self-auto shrink-0">
            <span class="text-[9px] font-black uppercase tracking-widest text-gray-400">Identity Shield Active</span>
        </div>
    </div>

    @php
    $metrics = [
        ['num'=>1, 'cat'=>'Leadership',    'q'=>'"Leadership vision and culture building."'],
        ['num'=>2, 'cat'=>'Support',       'q'=>'"Availability and support for staff development."'],
        ['num'=>3, 'cat'=>'Communication', 'q'=>'"Clarity and transparency in daily communication."'],
    ];
    $ratingOwners = [
        ['name'=>'Sarah Anderson', 'role'=>'Owner', 'defaults'=>[90,100,80], 'img'=>'https://i.pravatar.cc/40?img=47'],
        ['name'=>'Marcus Thorne',  'role'=>'Owner', 'defaults'=>[80,100,90], 'img'=>'https://i.pravatar.cc/40?img=12'],
        ['name'=>'Elena Vance',    'role'=>'Owner', 'defaults'=>[80,100,80], 'img'=>'https://i.pravatar.cc/40?img=45'],
    ];
    $scale = [10,20,30,40,50,60,70,80,90,100];
    @endphp

    @foreach($metrics as $m)
    <div class="mb-6">
        <p class="text-[10px] font-black uppercase tracking-widest text-purple-500 mb-1">Metric #{{ $m['num'] }} · {{ $m['cat'] }}</p>
        <p class="text-lg font-black text-zinc-900 italic mb-4">{{ $m['q'] }}</p>
        <div class="bg-white rounded-3xl border border-zinc-100 shadow-sm overflow-hidden">
            @foreach($ratingOwners as $oi => $owner)
            @php
                $fieldId = 'm'.$m['num'].'_o'.$oi;
                $defVal  = $owner['defaults'][$m['num']-1] ?? 80;
            @endphp
            <div class="flex flex-col lg:flex-row lg:items-center gap-4 px-6 py-5 border-b border-zinc-100 last:border-b-0">
                <div class="flex items-center gap-3 lg:w-48 shrink-0">
                    <div class="w-10 h-10 rounded-xl overflow-hidden shrink-0 bg-zinc-100">
                        <img src="{{ $owner['img'] }}" alt="" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <p class="text-sm font-bold text-zinc-900 leading-4">{{ $owner['name'] }}</p>
                        <p class="text-[9px] font-black uppercase tracking-widest text-gray-400 mt-0.5">{{ $owner['role'] }}</p>
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-2">Assign Rating (10-100)</p>
                    <div class="flex items-center gap-1.5 flex-wrap">
                        @foreach($scale as $step)
                        <button type="button"
                                id="btn_{{ $fieldId }}_{{ $step }}"
                                data-field="{{ $fieldId }}"
                                data-step="{{ $step }}"
                                onclick="setRating(this.dataset.field, parseInt(this.dataset.step))"
                                class="w-9 h-9 rounded-xl text-[10px] font-black transition-all cursor-pointer border-0
                                       {{ $step == $defVal ? 'rating-active' : 'bg-gray-100 text-gray-400 hover:bg-purple-50 hover:text-purple-600' }}">
                            {{ $step }}
                        </button>
                        @endforeach
                    </div>
                    <input type="hidden" id="val_{{ $fieldId }}" value="{{ $defVal }}">
                </div>
                <div class="lg:w-12 flex lg:justify-end shrink-0">
                    <span id="disp_{{ $fieldId }}" class="text-2xl font-black text-purple-600 tabular-nums">{{ $defVal }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <div class="flex justify-end mb-2">
        <button onclick="openSelfPerf()"
                class="px-7 py-3 bg-purple-600 hover:bg-purple-700 rounded-2xl text-[11px] font-black uppercase tracking-widest text-white transition-colors border-0 cursor-pointer">
            View Analytics Summary
        </button>
    </div>
</div>

</div>{{-- end wrapper --}}


{{-- MODAL: Self Performance --}}
<div id="modalSelfPerf" style="display:none;position:fixed;inset:0;z-index:9999;align-items:center;justify-content:center;padding:1rem;background:rgba(0,0,0,.45);backdrop-filter:blur(5px);">
    <div class="bg-white rounded-3xl w-full max-w-sm shadow-2xl overflow-hidden">
        <div class="flex items-start justify-between px-6 pt-6 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-600 rounded-2xl flex items-center justify-center shrink-0">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <polyline points="2,13 6,7 9,10 12,5 16,13" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                </div>
                <div>
                    <p class="font-mono text-sm font-black text-zinc-900">Self Performance Index</p>
                    <p class="text-[9px] font-bold uppercase tracking-widest text-gray-400 mt-0.5">Wide Aggregated Category Averages</p>
                </div>
            </div>
            <button onclick="closeSelfPerf()" style="background:transparent;border:0;cursor:pointer;" class="w-7 h-7 flex items-center justify-center rounded-xl hover:bg-zinc-100 text-gray-400 shrink-0">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <line x1="2" y1="2" x2="12" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    <line x1="12" y1="2" x2="2" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </button>
        </div>
        <div class="px-6 pb-6">
            <div class="grid grid-cols-3 gap-2 mb-4">
                @php
                $spMetrics = [
                    ['label'=>'Shop Standards',    'val'=>92],
                    ['label'=>'Customer Vibe',     'val'=>88],
                    ['label'=>'Operational Speed', 'val'=>76],
                    ['label'=>'Internal Support',  'val'=>84],
                    ['label'=>'Growth Strategy',   'val'=>70],
                    ['label'=>'Technical Accuracy','val'=>90],
                ];
                @endphp
                @foreach($spMetrics as $sm)
                <div class="bg-gray-50 rounded-2xl p-3 border border-zinc-100">
                    <p class="text-[8px] font-black uppercase tracking-widest text-gray-400 leading-3 mb-2">{{ $sm['label'] }}</p>
                    <p class="text-2xl font-black text-purple-600 leading-none mb-2 tabular-nums">{{ $sm['val'] }}</p>
                    <div class="w-full h-1 bg-gray-200 rounded-full overflow-hidden">
                        {{-- FIX PAMUNGKAS: Menggunakan Laravel @style directive! --}}
                        <div class="h-full bg-purple-600 rounded-full" @style(["width: {$sm['val']}%"])></div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-2xl border border-zinc-100">
                <div class="flex-1 min-w-0">
                    <p class="text-[11px] font-black text-zinc-900 leading-4 mb-1">Comprehensive Introspection Ready</p>
                    <p class="text-[10px] text-gray-500 leading-4">The workspace is currently performing at <span class="font-bold text-zinc-900">88% capacity</span> relative to targets. High scores in Safety and Experience are driving growth.</p>
                </div>
                <button onclick="closeSelfPerf()" style="background:#9333ea;border:0;cursor:pointer;" class="shrink-0 px-3 py-2.5 rounded-xl text-[9px] font-black uppercase tracking-widest text-white whitespace-nowrap leading-tight text-center">
                    Close<br>Analytics Hub
                </button>
            </div>
        </div>
    </div>
</div>


{{-- MODAL: Confidential Analyze --}}
<div id="modalConfidential" style="display:none;position:fixed;inset:0;z-index:9999;align-items:center;justify-content:center;padding:1rem;background:rgba(0,0,0,.45);backdrop-filter:blur(5px);">
    <div class="bg-white rounded-[28px] w-full max-w-lg shadow-2xl overflow-hidden">
        <div class="flex items-center gap-4 px-6 py-5 border-b border-zinc-100">
            <div id="confAvatar" class="w-12 h-12 bg-zinc-100 rounded-2xl flex items-center justify-center text-lg font-black text-gray-500 shrink-0">AC</div>
            <div class="flex-1 min-w-0">
                <p id="confName" class="text-xl font-black text-zinc-900 truncate">Alex Chen</p>
                <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mt-0.5">Confidential Aggregated Analytics</p>
            </div>
            <button onclick="closeConfidential()" style="background:transparent;border:0;cursor:pointer;" class="w-8 h-8 flex items-center justify-center rounded-xl hover:bg-zinc-100 text-gray-400 shrink-0">
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none">
                    <line x1="2.5" y1="2.5" x2="12.5" y2="12.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    <line x1="12.5" y1="2.5" x2="2.5" y2="12.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </button>
        </div>
        <div class="p-6">
            <div class="flex flex-col sm:flex-row gap-4 mb-5">
                <div class="flex-1 rounded-[20px] p-5" style="background:#f3f0ff;">
                    <p class="text-[10px] font-black uppercase tracking-widest mb-3" style="color:#a78bfa;">Cumulative Index</p>
                    <div class="flex items-end gap-3 mb-2">
                        <span id="confScore" class="font-mono font-black leading-none tabular-nums" style="font-size:4rem;color:#7c3aed;">88</span>
                        <div class="pb-1">
                            <p class="text-[9px] font-black uppercase tracking-widest" style="color:#c4b5fd;">Scale</p>
                            <p class="text-xl font-black" style="color:#c4b5fd;">/ 100</p>
                        </div>
                    </div>
                    <p id="confCycles" class="text-sm font-medium" style="color:#a78bfa;">Aggregated from 18 cycles</p>
                </div>
                <div class="flex-1 bg-white rounded-[20px] border border-zinc-100 p-5 flex flex-col gap-3">
                    <div class="flex items-center gap-2">
                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                            <circle cx="6.5" cy="4.5" r="2.5" stroke="#9ca3af" stroke-width="1.2" fill="none"/>
                            <path d="M2 11.5a4.5 4.5 0 019 0" stroke="#9ca3af" stroke-width="1.2" stroke-linecap="round" fill="none"/>
                        </svg>
                        <span class="text-[9px] font-black uppercase tracking-widest text-gray-400">Real-time Feed</span>
                    </div>
                    <p class="text-[10px] text-gray-500 leading-5 italic flex-1">"Performance data is aggregated in real-time. Staff identity remains strictly encrypted to preserve the integrity of our feedback loop."</p>
                    <div class="flex gap-2">
                        <div class="flex-1 bg-zinc-50 rounded-xl px-3 py-2 border border-zinc-100">
                            <p class="text-[9px] font-black uppercase tracking-widest text-gray-400 mb-1">Total Hits</p>
                            <p id="confHits" class="text-xl font-black text-zinc-900 tabular-nums">6</p>
                        </div>
                        <div class="flex-1 rounded-xl px-3 py-2 border" style="background:#f0fdf4;border-color:#bbf7d0;">
                            <p class="text-[9px] font-black uppercase tracking-widest mb-1" style="color:#16a34a;">Status</p>
                            <p class="text-xl font-black" style="color:#16a34a;">Sync</p>
                        </div>
                    </div>
                </div>
            </div>
            <button onclick="closeConfidential()" style="background:#9333ea;border:0;cursor:pointer;" class="w-full py-3.5 hover:bg-purple-700 rounded-2xl text-[11px] font-black uppercase tracking-widest text-white transition-colors">
                Close Confidential Analysis
            </button>
        </div>
    </div>
</div>

@endsection


@push('styles')
<style>
    @keyframes slideUp {
        from { opacity:0; transform:translateY(16px); }
        to   { opacity:1; transform:translateY(0); }
    }
    #modalSelfPerf > div,
    #modalConfidential > div { animation: slideUp .2s ease; }
    .filter-tab { background:transparent; color:#9ca3af; }
    .filter-tab.is-active { background:#9333ea !important; color:#fff !important; box-shadow:0 2px 8px rgba(147,51,234,.35) !important; }
    .filter-tab:not(.is-active):hover { background:rgba(147,51,234,.08) !important; color:#9333ea !important; }
    .rating-active { background:#9333ea !important; color:white !important; }
</style>
@endpush


@push('scripts')
<script>
/* ── Smart routing: Owner → Audit View, Staff → Confidential Popup ── */
function handleAnalyze(data) {
    if (data.role === 'owner') {
        openAudit(data);
    } else {
        openAuditModal(data);
    }
}

function setFilter(btn, filter) {
    document.querySelectorAll('.filter-tab').forEach(function(t){ t.classList.remove('is-active'); });
    btn.classList.add('is-active');
    document.querySelectorAll('.staff-row').forEach(function(row){
        row.style.display = (filter === 'all' || row.dataset.group === filter) ? '' : 'none';
    });
}

function openAudit(data) {
    document.getElementById('auditName').textContent = data.name + ' — Active Management Audit';
    document.getElementById('viewScoreboard').style.display = 'none';
    document.getElementById('viewAudit').style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
function closeAudit() {
    document.getElementById('viewAudit').style.display = 'none';
    document.getElementById('viewScoreboard').style.display = 'block';
}

function setRating(fieldId, value) {
    document.getElementById('val_' + fieldId).value = value;
    document.getElementById('disp_' + fieldId).textContent = value;
    [10,20,30,40,50,60,70,80,90,100].forEach(function(step){
        var b = document.getElementById('btn_' + fieldId + '_' + step);
        if (!b) return;
        if (step === value) { b.classList.add('rating-active'); b.classList.remove('bg-gray-100','text-gray-400'); }
        else { b.classList.remove('rating-active'); b.classList.add('bg-gray-100','text-gray-400'); }
    });
}

function openSelfPerf() { document.getElementById('modalSelfPerf').style.display = 'flex'; }
function closeSelfPerf() { document.getElementById('modalSelfPerf').style.display = 'none'; }

function openAuditModal(data) {
    var words = data.name.split(' ');
    var initials = words.slice(0,2).map(function(w){ return w.charAt(0).toUpperCase(); }).join('');
    document.getElementById('confName').textContent   = data.name;
    document.getElementById('confAvatar').textContent = initials;
    document.getElementById('confScore').textContent  = data.score;
    document.getElementById('confHits').textContent   = data.hits;
    document.getElementById('confCycles').textContent = 'Aggregated from ' + data.hits + ' cycles';
    document.getElementById('modalConfidential').style.display = 'flex';
}
function closeConfidential() { document.getElementById('modalConfidential').style.display = 'none'; }

document.getElementById('modalSelfPerf').addEventListener('click', function(e){ if(e.target===this) closeSelfPerf(); });
document.getElementById('modalConfidential').addEventListener('click', function(e){ if(e.target===this) closeConfidential(); });
document.addEventListener('keydown', function(e){ if(e.key==='Escape'){ closeSelfPerf(); closeConfidential(); } });
</script>
@endpush