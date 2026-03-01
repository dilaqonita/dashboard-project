@extends('layouts.app')

@section('title', 'Overtime Requests')

@section('content')

<div class="px-4 sm:px-6 lg:px-8 py-7 w-full">

    {{-- ===== PAGE HEADER ===== --}}
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-5 mb-8">
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-purple-600 shrink-0" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="6.5"/>
                    <path d="M8 4.5v3.8l2.5 2.5"/>
                </svg>
                <span class="text-[10px] font-bold uppercase tracking-widest text-purple-600">Overtime Portal</span>
            </div>
            <h1 class="font-mono font-bold text-2xl sm:text-3xl text-zinc-900 leading-tight">Your Overtime Submissions</h1>
            <p class="font-mono text-sm text-gray-400">Request overtime hours by submitting work details and proof.</p>
        </div>

        {{-- Tombol buka modal - onclick langsung, tidak butuh Alpine --}}
        <button
            type="button"
            onclick="OT.open()"
            class="flex items-center justify-center gap-2.5 px-6 h-12 bg-purple-600 rounded-2xl
                   text-white text-xs font-black uppercase tracking-widest
                   shadow-[0px_10px_15px_-3px_rgba(147,51,234,0.25)]
                   hover:bg-purple-700 active:scale-95 transition-all duration-150 shrink-0 self-start whitespace-nowrap">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 20 20">
                <path d="M10 4v12M4 10h12" stroke-linecap="round"/>
            </svg>
            Submit New Request
        </button>
    </div>

    {{-- ===== MAIN GRID ===== --}}
    <div class="flex flex-col lg:flex-row gap-6 items-start">

        {{-- LEFT: Submission Log --}}
        <div class="flex-1 min-w-0 bg-white rounded-[28px] border border-zinc-100 shadow-sm overflow-hidden">

            <div class="px-5 sm:px-8 h-16 border-b border-zinc-100 flex items-center justify-between gap-4">
                <span class="text-[10px] font-black uppercase tracking-widest text-zinc-400">Submission Log</span>

                {{-- Filter Dropdown --}}
                <div class="relative" id="dd-wrapper">
                    <button type="button"
                            onclick="OT.toggleDd()"
                            class="flex items-center gap-2 px-4 py-1.5 bg-white rounded-2xl border border-zinc-100
                                   hover:border-purple-300 hover:bg-purple-50/30 transition-all duration-150">
                        <svg class="w-3.5 h-3.5 text-purple-600 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 14 14">
                            <circle cx="6" cy="6" r="4.5"/>
                            <path d="M10.5 10.5l2 2"/>
                        </svg>
                        <span id="dd-label" class="text-[10px] font-black uppercase tracking-widest text-purple-600 whitespace-nowrap">Recent Activity</span>
                        <svg id="dd-chevron" class="w-3 h-3 text-purple-400 transition-transform duration-200"
                             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 12 12">
                            <path d="M3 4.5l3 3 3-3"/>
                        </svg>
                    </button>

                    <div id="dd-panel"
                         class="absolute right-0 top-full mt-2 w-48 bg-white rounded-2xl border border-zinc-100
                                shadow-[0px_10px_25px_-5px_rgba(0,0,0,0.12)] z-30"
                         style="display:none;">
                        <div class="p-2 space-y-0.5">
                            <button type="button" onclick="OT.filter('all','All Submissions')"
                                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-zinc-700 text-left hover:bg-purple-50 hover:text-purple-700 transition-colors">
                                <span class="w-2 h-2 rounded-full bg-zinc-300 shrink-0"></span>All Submissions
                            </button>
                            <button type="button" onclick="OT.filter('pending','Pending')"
                                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-zinc-700 text-left hover:bg-purple-50 hover:text-purple-700 transition-colors">
                                <span class="w-2 h-2 rounded-full bg-amber-400 shrink-0"></span>Pending
                            </button>
                            <button type="button" onclick="OT.filter('approved','Approved')"
                                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-zinc-700 text-left hover:bg-purple-50 hover:text-purple-700 transition-colors">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 shrink-0"></span>Approved
                            </button>
                            <button type="button" onclick="OT.filter('rejected','Rejected')"
                                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-zinc-700 text-left hover:bg-purple-50 hover:text-purple-700 transition-colors">
                                <span class="w-2 h-2 rounded-full bg-red-400 shrink-0"></span>Rejected
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full" style="min-width:520px">
                    <thead>
                        <tr class="border-b border-zinc-100 bg-gray-50/10">
                            <th class="px-5 sm:px-8 py-5 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400 w-44">Work Date</th>
                            <th class="px-4 py-5 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400 w-28">Duration</th>
                            <th class="px-4 py-5 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">Description</th>
                            <th class="px-5 sm:px-8 py-5 text-right text-[10px] font-bold uppercase tracking-widest text-gray-400">Status</th>
                        </tr>
                    </thead>
                    <tbody id="overtime-table-body" class="divide-y divide-zinc-100/60">
                        @php
                            $overtimes = $overtimes ?? [
                                ['date' => '2026-02-04', 'duration' => '3h',   'description' => 'Stock take and inventory audit',   'status' => 'pending'],
                                ['date' => '2026-01-28', 'duration' => '1.5h', 'description' => 'Kitchen deep clean after closing.', 'status' => 'approved'],
                            ];
                        @endphp

                        @forelse ($overtimes as $ot)
                            <tr class="ot-row hover:bg-purple-50/20 transition-colors duration-150" data-status="{{ $ot['status'] }}">
                                <td class="px-5 sm:px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-purple-600/5 rounded-xl flex items-center justify-center shrink-0">
                                            <svg class="w-4.5 h-4.5 text-purple-500" fill="none" stroke="currentColor" stroke-width="1.67" viewBox="0 0 20 20">
                                                <rect x="2.5" y="3.33" width="15" height="13.33" rx="1.5"/>
                                                <path d="M6.67 1.67v3.33M13.33 1.67v3.33"/>
                                                <line x1="2.5" y1="8.33" x2="17.5" y2="8.33"/>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-bold text-zinc-900 whitespace-nowrap">{{ $ot['date'] }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-5">
                                    <span class="text-sm font-black text-zinc-900">{{ $ot['duration'] }}</span>
                                </td>
                                <td class="px-4 py-5">
                                    <span class="text-xs text-gray-400 font-medium leading-relaxed">{{ $ot['description'] }}</span>
                                </td>
                                <td class="px-5 sm:px-8 py-5 text-right">
                                    @if ($ot['status'] === 'approved')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100 whitespace-nowrap">Approved</span>
                                    @elseif ($ot['status'] === 'pending')
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100 whitespace-nowrap">Pending</span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-red-50 text-red-500 border border-red-100 whitespace-nowrap">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-12 h-12 bg-purple-600/5 rounded-2xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-bold text-gray-300">No overtime submissions yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div id="filter-empty-state" class="hidden px-8 py-14 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-12 h-12 bg-purple-600/5 rounded-2xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/>
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-300">No submissions match this filter.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT Sidebar --}}
        <div class="flex flex-col gap-5 w-full lg:w-80 shrink-0">
            <div class="relative bg-purple-600 rounded-[28px] p-8 overflow-hidden shadow-[0px_20px_40px_-10px_rgba(147,51,234,0.30)]">
                <div class="absolute -top-8 -right-8 w-36 h-36 bg-white/5 rounded-full pointer-events-none"></div>
                <div class="absolute -bottom-10 -left-6 w-44 h-44 bg-white/5 rounded-full pointer-events-none"></div>
                <div class="relative z-10">
                    <div class="w-11 h-11 bg-white/20 rounded-xl flex items-center justify-center mb-8">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/>
                            <polyline points="16 7 22 7 22 13"/>
                        </svg>
                    </div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-white/60 mb-1">This Month's OT</p>
                    <div class="flex items-baseline gap-2 mb-5">
                        <span class="text-5xl font-black text-white leading-none">{{ $thisMonthOT ?? '12.5' }}</span>
                        <span class="text-lg font-black text-white/40">hours</span>
                    </div>
                    <p class="text-xs font-medium text-white/60 leading-5 italic">
                        "Your approved overtime will be automatically calculated into your next salary statement."
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-[28px] border border-zinc-100 shadow-sm px-7 pt-7 pb-6">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 mb-5">Submission Rules</p>
                <ul class="space-y-4">
                    @foreach (['Submit with clear work photo', 'Detail the reason for extension', 'Report within 24h of shift'] as $rule)
                        <li class="flex items-center gap-3">
                            <div class="w-5 h-5 bg-emerald-50 rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 12 12">
                                    <path d="M2 6.5l2.5 2.5 5.5-5"/>
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-zinc-700">{{ $rule }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════
     MODAL — DI LUAR semua div, langsung di body level
     Dikontrol murni Vanilla JS via OT.open() / OT.close()
     TIDAK butuh Alpine.js sama sekali
══════════════════════════════════════════ --}}
<div id="ot-modal-overlay"
     style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:9999;
            background:rgba(0,0,0,0.5); backdrop-filter:blur(6px);"
     onclick="if(event.target===this) OT.close()">

    <div id="ot-modal-panel"
         style="position:absolute; bottom:0; left:0; right:0;
                background:#ffffff; border-radius:32px 32px 0 0;
                max-height:92vh; overflow-y:auto;
                transform:translateY(30px); opacity:0;
                transition:transform 0.28s cubic-bezier(.22,1,.36,1), opacity 0.2s ease;">

        {{-- Header --}}
        <div class="px-6 sm:px-10 pt-7 sm:pt-8 pb-0">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-4 h-4 text-purple-600 shrink-0" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="6.5"/>
                            <path d="M8 4.5v3.8l2.5 2.5"/>
                        </svg>
                        <span class="text-[10px] font-black uppercase tracking-widest text-purple-600">New Submission</span>
                    </div>
                    <h2 class="font-mono font-bold text-2xl sm:text-3xl text-zinc-900 leading-tight">Request Overtime</h2>
                    <p class="font-mono text-sm text-gray-400 mt-1">Please provide accurate details for administrative review.</p>
                </div>
                <button type="button" onclick="OT.close()" aria-label="Close"
                        class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 transition-colors shrink-0 mt-1">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M18 6 6 18M6 6l12 12" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Form --}}
        <form id="overtime-form" class="px-6 sm:px-10 pt-7 pb-8" onsubmit="OT.submit(event)">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-7 gap-y-5">

                {{-- LEFT --}}
                <div class="space-y-5">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 pl-1">Work Date</label>
                        <div class="relative">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" stroke-width="1.33" viewBox="0 0 16 16">
                                    <rect x="2" y="2.67" width="12" height="11.33" rx="1.5"/>
                                    <path d="M5.33 1.33v2.67M10.67 1.33v2.67"/>
                                    <line x1="2" y1="6.67" x2="14" y2="6.67"/>
                                </svg>
                            </div>
                            <input type="date" name="work_date" id="ot-work-date" required
                                   class="w-full py-3.5 pl-10 pr-4 bg-gray-50 border border-zinc-100 rounded-2xl
                                          text-sm font-medium text-zinc-900
                                          focus:outline-none focus:border-purple-400 focus:ring-2 focus:ring-purple-100
                                          transition-all duration-150">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 pl-1">Duration (Hours)</label>
                        <input type="number" name="duration" id="ot-duration" step="0.5" min="0.5" max="24"
                               placeholder="e.g. 2.5" required
                               class="w-full py-3.5 px-5 bg-gray-50 border border-zinc-100 rounded-2xl
                                      text-sm font-black text-zinc-900 placeholder:text-zinc-300
                                      focus:outline-none focus:border-purple-400 focus:ring-2 focus:ring-purple-100
                                      transition-all duration-150">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 pl-1">Work Reason</label>
                        <textarea name="reason" id="ot-reason" rows="5"
                                  placeholder="Briefly describe why you worked extra hours..." required
                                  class="w-full px-5 py-4 bg-gray-50 border border-zinc-100 rounded-2xl
                                         text-sm font-medium text-zinc-900 placeholder:text-zinc-300 resize-none leading-relaxed
                                         focus:outline-none focus:border-purple-400 focus:ring-2 focus:ring-purple-100
                                         transition-all duration-150"></textarea>
                    </div>
                </div>

                {{-- RIGHT --}}
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-2 pl-1">Work Evidence (Photo)</label>
                        <label for="proof-upload"
                               class="group flex flex-col items-center justify-center gap-4 p-6
                                      bg-gray-50 border-2 border-dashed border-zinc-200 rounded-3xl
                                      cursor-pointer hover:border-purple-400 hover:bg-purple-50/20
                                      transition-all duration-200 min-h-49">
                            <div class="w-14 h-14 bg-white rounded-[18px] shadow-sm flex items-center justify-center group-hover:shadow-md transition-shadow duration-200">
                                <svg class="w-7 h-7 text-purple-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 28 28">
                                    <rect x="2.33" y="5.83" width="23.33" height="18.33" rx="2.5"/>
                                    <circle cx="14" cy="14.5" r="4"/>
                                    <path d="M9.33 5.83l1.67-3.5h6l1.67 3.5"/>
                                    <circle cx="22" cy="8.5" r="1.2" fill="currentColor" stroke="none"/>
                                </svg>
                            </div>
                            <div class="text-center pointer-events-none">
                                <p id="upload-name" class="text-sm font-black text-zinc-900">Upload Proof</p>
                                <p id="upload-hint" class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mt-0.5">JPG, PNG &bull; MAX 5MB</p>
                            </div>
                            <input id="proof-upload" type="file" name="proof" accept="image/jpeg,image/png" class="hidden"
                                   onchange="OT.fileChange(this)">
                        </label>
                    </div>

                    <div class="flex items-start gap-3 px-5 py-4 bg-purple-600/5 rounded-2xl border border-purple-600/10">
                        <svg class="w-5 h-5 text-purple-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="1.67" viewBox="0 0 20 20">
                            <circle cx="10" cy="10" r="8.33"/>
                            <path d="M10 6.67v.01M10 10v5"/>
                        </svg>
                        <p class="text-[10px] font-bold text-purple-600 leading-relaxed">
                            Apakah Anda yakin semua rincian sudah benar? Tindakan ini akan langsung mencatat data ke dalam sistem audit.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="mt-7 pt-6 border-t border-zinc-100 grid grid-cols-2 gap-4">
                <button type="button" onclick="OT.close()"
                        class="flex items-center justify-center py-3.5 bg-gray-100 rounded-2xl
                               text-xs font-black uppercase tracking-widest text-zinc-700
                               hover:bg-gray-200 active:scale-95 transition-all duration-150">
                    Discard
                </button>
                <button type="submit"
                        class="flex items-center justify-center gap-3 py-3.5 bg-purple-600 rounded-2xl
                               text-xs font-black uppercase tracking-widest text-white
                               shadow-[0px_10px_15px_-3px_rgba(147,51,234,0.25)]
                               hover:bg-purple-700 active:scale-95 transition-all duration-150">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 16 16">
                        <path d="M14 2L2 7.5l5 2.5 2.5 5L14 2z"/>
                    </svg>
                    Submit for Review
                </button>
            </div>
        </form>
    </div>
</div>

@endsection


@push('styles')
<style>
    @media (min-width: 640px) {
        #ot-modal-panel {
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            bottom: auto !important;
            right: auto !important;
            transform: translate(-50%, -46px) !important;
            width: calc(100% - 2rem) !important;
            max-width: 700px !important;
            border-radius: 32px !important;
            opacity: 0 !important;
            transition: transform 0.28s cubic-bezier(.22,1,.36,1), opacity 0.2s ease !important;
        }
        #ot-modal-panel.is-open {
            transform: translate(-50%, -50%) !important;
            opacity: 1 !important;
        }
    }
</style>
@endpush


@push('scripts')
<script>
var OT = (function () {
    'use strict';

    var overlay = document.getElementById('ot-modal-overlay');
    var panel   = document.getElementById('ot-modal-panel');
    var form    = document.getElementById('overtime-form');
    var dateEl  = document.getElementById('ot-work-date');

    /* Isi tanggal hari ini */
    if (dateEl) {
        var d  = new Date();
        dateEl.value = d.getFullYear() + '-'
            + String(d.getMonth() + 1).padStart(2, '0') + '-'
            + String(d.getDate()).padStart(2, '0');
    }

    /* ESC tutup modal */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && overlay.style.display !== 'none') close();
    });

    /* Tutup dropdown kalau klik di luar */
    document.addEventListener('click', function (e) {
        var wrapper = document.getElementById('dd-wrapper');
        var ddPanel = document.getElementById('dd-panel');
        if (wrapper && ddPanel && !wrapper.contains(e.target)) {
            ddPanel.style.display = 'none';
            var chevron = document.getElementById('dd-chevron');
            if (chevron) chevron.style.transform = '';
        }
    });

    function open() {
        overlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
        /* Animasi masuk */
        requestAnimationFrame(function () {
            panel.style.transform = 'translateY(0)';
            panel.style.opacity   = '1';
            panel.classList.add('is-open');
        });
    }

    function close() {
        panel.style.opacity   = '0';
        panel.classList.remove('is-open');
        /* Mobile */
        if (window.innerWidth < 640) panel.style.transform = 'translateY(30px)';
        setTimeout(function () {
            overlay.style.display = 'none';
            document.body.style.overflow = '';
        }, 250);
    }

    function toggleDd() {
        var ddPanel = document.getElementById('dd-panel');
        var chevron = document.getElementById('dd-chevron');
        var isOpen  = ddPanel.style.display !== 'none';
        ddPanel.style.display   = isOpen ? 'none' : 'block';
        if (chevron) chevron.style.transform = isOpen ? '' : 'rotate(180deg)';
        event.stopPropagation();
    }

    function filter(value, label) {
        document.getElementById('dd-label').textContent = label;
        document.getElementById('dd-panel').style.display = 'none';
        var chevron = document.getElementById('dd-chevron');
        if (chevron) chevron.style.transform = '';

        var rows    = document.querySelectorAll('.ot-row');
        var visible = 0;
        rows.forEach(function (row) {
            var show = (value === 'all' || row.dataset.status === value);
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        document.getElementById('filter-empty-state').classList.toggle('hidden', visible > 0);
    }

    function fileChange(input) {
        var nameEl = document.getElementById('upload-name');
        var hintEl = document.getElementById('upload-hint');
        if (input.files && input.files[0]) {
            nameEl.textContent      = input.files[0].name;
            nameEl.style.color      = '#059669';
            hintEl.textContent      = 'File selected ✓';
            hintEl.style.color      = '#6ee7b7';
        }
    }

    function submit(e) {
        e.preventDefault();
        var date     = document.getElementById('ot-work-date').value;
        var duration = document.getElementById('ot-duration').value;
        var reason   = document.getElementById('ot-reason').value;
        if (!date || !duration || !reason) {
            alert('Harap isi semua field yang wajib diisi.');
            return;
        }
        /*
         * TODO: ganti alert ini dengan fetch ke backend:
         * var fd = new FormData(form);
         * fetch('{{ route("overtime.store") }}', {
         * method: 'POST',
         * headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
         * body: fd
         * }).then(r => r.json()).then(function(data) { ... });
         */
        alert('Overtime request berhasil dikirim!');
        form.reset();
        document.getElementById('upload-name').textContent = 'Upload Proof';
        document.getElementById('upload-name').style.color = '';
        document.getElementById('upload-hint').textContent = 'JPG, PNG • MAX 5MB';
        document.getElementById('upload-hint').style.color = '';
        close();
    }

    return { open: open, close: close, toggleDd: toggleDd, filter: filter, fileChange: fileChange, submit: submit };
})();
</script>
@endpush