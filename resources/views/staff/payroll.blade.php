@extends('layouts.app')

@section('title', 'Pay Slips')

@section('content')

<div class="px-4 sm:px-6 lg:px-10 py-6 sm:py-8 max-w-7xl mx-auto space-y-6 sm:space-y-10">

    {{-- ===== PAGE HEADER ===== --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

        {{-- Title Block --}}
        <div class="space-y-1">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-purple-600 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 16 16">
                    <circle cx="8" cy="8" r="6"/>
                    <path d="M8 5v3l2 1"/>
                </svg>
                <span class="text-[10px] font-bold uppercase tracking-widest text-purple-600">Earnings History</span>
            </div>
            <h1 class="font-mono font-bold text-2xl sm:text-3xl text-zinc-900 leading-tight">Your Pay Slips</h1>
            <p class="font-mono text-xs sm:text-sm text-gray-400">View and download your official monthly salary statements.</p>
        </div>

        {{-- Last Amount Card --}}
        <div class="flex items-center gap-4 px-5 py-4 sm:px-6 sm:py-5 bg-purple-50 rounded-3xl sm:rounded-3xl border border-purple-100/60 self-start">
            <div class="w-11 h-11 sm:w-14 sm:h-14 bg-purple-600 rounded-2xl sm:rounded-2xl shadow-[0px_20px_25px_-5px_rgba(147,51,234,0.30)] flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/>
                    <polyline points="16 7 22 7 22 13"/>
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-purple-400 mb-0.5">Last Amount</p>
                <p class="text-xl sm:text-2xl font-black text-zinc-900 font-mono">
                    {{ isset($lastAmount) ? number_format($lastAmount, 2) : '0.000.000' }}
                </p>
            </div>
        </div>
    </div>

    {{-- ===== PAYMENT REGISTRY ===== --}}
    <div class="bg-white rounded-3xl sm:rounded-3xl border border-zinc-100 shadow-sm overflow-hidden">

        {{-- Table Header Bar --}}
        <div class="px-4 sm:px-8 h-14 sm:h-16 border-b border-zinc-100 flex items-center justify-between gap-4">
            <span class="text-[10px] sm:text-xs font-black uppercase tracking-widest text-zinc-400">Payment Registry</span>
            <div class="flex items-center gap-2 px-3 py-1.5 bg-white rounded-2xl border border-zinc-100 shadow-sm">
                <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 14 14">
                    <circle cx="6" cy="6" r="4.5"/>
                    <path d="M6 4v2M6 8h.01"/>
                </svg>
                <span class="text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-gray-400">Official Records</span>
            </div>
        </div>

        @php
            $payslips = $payslips ?? [
                ['id' => 1, 'period' => 'February 2026', 'released' => '2026-02-01', 'amount' => 2100.5,  'cycle' => 'FEBRUARY 2026', 'ref' => 'H1'],
                ['id' => 2, 'period' => 'January 2026',  'released' => '2026-01-01', 'amount' => 2050.0,  'cycle' => 'JANUARY 2026',  'ref' => 'H2'],
                ['id' => 3, 'period' => 'December 2025', 'released' => '2025-12-01', 'amount' => 2150.0,  'cycle' => 'DECEMBER 2025', 'ref' => 'H3'],
                ['id' => 4, 'period' => 'November 2025', 'released' => '2025-11-01', 'amount' => 1980.0,  'cycle' => 'NOVEMBER 2025', 'ref' => 'H4'],
            ];
            $employee = $employee ?? [
                'name'       => 'John Lennon',
                'role'       => 'Barista',
                'account_id' => '5621',
            ];
        @endphp

        {{-- ── MOBILE CARD LIST (< sm) ── --}}
        <div class="block sm:hidden divide-y divide-zinc-100/70">
            @forelse ($payslips as $slip)
                <div class="px-4 py-5 flex items-center justify-between gap-3">
                    {{-- Left: icon + info --}}
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 bg-purple-600/5 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" stroke-width="1.67" viewBox="0 0 20 20">
                                <path d="M4 2h8l4 4v12a1 1 0 01-1 1H4a1 1 0 01-1-1V3a1 1 0 011-1z"/>
                                <path d="M12 2v4h4M7 9h6M7 12h4"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-zinc-900 truncate">{{ $slip['period'] }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">{{ $slip['released'] }}</p>
                            <p class="text-sm font-black text-zinc-900 mt-0.5">
                                ${{ $slip['amount'] != floor($slip['amount']) ? number_format($slip['amount'], 1) : number_format($slip['amount'], 0) }}
                            </p>
                        </div>
                    </div>
                    {{-- Right: actions --}}
                    <div class="flex items-center gap-2 shrink-0">
                        {{-- FIX #1: Ganti json_encode langsung di onclick dengan dataset! --}}
                        <button type="button" title="View"
                            data-slip="{{ json_encode($slip) }}" 
                            data-employee="{{ json_encode($employee) }}"
                            onclick="openModal(JSON.parse(this.dataset.slip), JSON.parse(this.dataset.employee))"
                            class="w-9 h-9 flex items-center justify-center bg-gray-100 rounded-xl border border-zinc-200/60 hover:bg-gray-200 active:scale-95 transition-all duration-150">
                            <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 16 16">
                                <ellipse cx="8" cy="8" rx="6" ry="3.8"/>
                                <circle cx="8" cy="8" r="1.5" fill="currentColor" stroke="none"/>
                            </svg>
                        </button>
                        <button type="button" title="Download"
                            class="w-9 h-9 flex items-center justify-center bg-purple-600 rounded-xl shadow-[0px_8px_12px_-3px_rgba(147,51,234,0.25)] hover:bg-purple-700 active:scale-95 transition-all duration-150">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 16 16">
                                <path d="M8 2v8M5 7.5l3 3 3-3M2 12.5h12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="px-6 py-14 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-12 h-12 bg-purple-600/5 rounded-2xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M9 12h6M9 16h4M6 2h9l5 5v15H4V2z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-300">No pay slips available yet.</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- ── TABLET & DESKTOP TABLE (≥ sm) ── --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full min-w-140">
                <thead>
                    <tr class="border-b border-zinc-100">
                        <th class="px-6 md:px-10 py-5 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400 w-2/5">Statement Cycle</th>
                        <th class="px-4 md:px-10 py-5 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">Released On</th>
                        <th class="px-4 md:px-10 py-5 text-left text-[10px] font-bold uppercase tracking-widest text-gray-400">Amount</th>
                        <th class="px-4 md:px-10 py-5 text-right text-[10px] font-bold uppercase tracking-widest text-gray-400 pr-6 md:pr-10">Options</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100/70">
                    @forelse ($payslips as $slip)
                        <tr class="group hover:bg-purple-50/30 transition-colors duration-150">
                            <td class="px-6 md:px-10 py-5 md:py-7">
                                <div class="flex items-center gap-3 md:gap-4">
                                    <div class="w-9 h-9 md:w-10 md:h-10 bg-purple-600/5 rounded-xl md:rounded-2xl flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 md:w-5 md:h-5 text-purple-500" fill="none" stroke="currentColor" stroke-width="1.67" viewBox="0 0 20 20">
                                            <path d="M4 2h8l4 4v12a1 1 0 01-1 1H4a1 1 0 01-1-1V3a1 1 0 011-1z"/>
                                            <path d="M12 2v4h4M7 9h6M7 12h4"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm md:text-base font-bold text-zinc-900">{{ $slip['period'] }}</span>
                                </div>
                            </td>
                            <td class="px-4 md:px-10 py-5 md:py-7">
                                <span class="text-xs font-bold text-gray-400 tracking-wide">{{ $slip['released'] }}</span>
                            </td>
                            <td class="px-4 md:px-10 py-5 md:py-7">
                                <span class="text-sm md:text-base font-black text-zinc-900">
                                    ${{ $slip['amount'] != floor($slip['amount']) ? number_format($slip['amount'], 1) : number_format($slip['amount'], 0) }}
                                </span>
                            </td>
                            <td class="px-4 md:px-10 py-5 md:py-7 pr-6 md:pr-10">
                                <div class="flex items-center justify-end gap-2 md:gap-3">
                                    {{-- FIX #2: Ganti json_encode langsung di onclick dengan dataset (untuk versi Desktop) --}}
                                    <button type="button" title="View Statement"
                                        data-slip="{{ json_encode($slip) }}" 
                                        data-employee="{{ json_encode($employee) }}"
                                        onclick="openModal(JSON.parse(this.dataset.slip), JSON.parse(this.dataset.employee))"
                                        class="w-9 h-9 md:w-10 md:h-10 flex items-center justify-center bg-gray-100 rounded-xl md:rounded-2xl border border-zinc-200/60 hover:bg-gray-200 active:scale-95 transition-all duration-150">
                                        <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 16 16">
                                            <ellipse cx="8" cy="8" rx="6" ry="3.8"/>
                                            <circle cx="8" cy="8" r="1.5" fill="currentColor" stroke="none"/>
                                        </svg>
                                    </button>
                                    <button type="button" title="Download Statement"
                                        class="w-9 h-9 md:w-10 md:h-10 flex items-center justify-center bg-purple-600 rounded-xl md:rounded-2xl shadow-[0px_10px_15px_-3px_rgba(147,51,234,0.25)] hover:bg-purple-700 active:scale-95 transition-all duration-150">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 16 16">
                                            <path d="M8 2v8M5 7.5l3 3 3-3M2 12.5h12"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-10 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-12 h-12 bg-purple-600/5 rounded-2xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-purple-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path d="M9 12h6M9 16h4M6 2h9l5 5v15H4V2z"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-bold text-gray-300">No pay slips available yet.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


{{-- ===== MODAL ===== --}}
{{-- FIX #3: Menghapus class `flex` yang bertabrakan dengan `hidden` --}}
<div id="salary-modal"
     class="fixed inset-0 z-50 items-end sm:items-center justify-center p-0 sm:p-4 hidden"
     role="dialog" aria-modal="true" aria-labelledby="modal-title">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/25 backdrop-blur-sm" onclick="closeModal()"></div>

    {{-- Panel —— bottom sheet di mobile, centered card di sm+ --}}
    <div id="modal-panel"
         class="relative bg-white
                w-full sm:max-w-2xl
                rounded-t-4xl sm:rounded-4xl
                shadow-[0px_-10px_40px_-5px_rgba(0,0,0,0.12)] sm:shadow-[0px_25px_60px_-15px_rgba(0,0,0,0.18)]
                overflow-hidden overflow-y-auto
                max-h-[92vh] sm:max-h-[90vh]
                transform transition-all duration-200
                translate-y-full sm:translate-y-0 sm:scale-95 opacity-0">

        {{-- Drag handle (mobile only) --}}
        <div class="flex justify-center pt-3 pb-1 sm:hidden">
            <div class="w-10 h-1 bg-zinc-200 rounded-full"></div>
        </div>

        {{-- HEADER --}}
        <div class="px-5 sm:px-8 pt-4 sm:pt-8 pb-5 sm:pb-6 border-b border-zinc-100">
            <div class="flex items-start justify-between gap-4">
                <div class="flex items-center gap-3 sm:gap-5">
                    {{-- Shield Icon --}}
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-purple-50 rounded-[18px] sm:rounded-[22px] flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-purple-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M12 2L4 5.5v6c0 5.2 3.5 9.8 8 11 4.5-1.2 8-5.8 8-11v-6L12 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 id="modal-title" class="font-mono font-bold text-lg sm:text-2xl text-zinc-900 leading-snug">
                            Official Salary Statement
                        </h2>
                        <p id="modal-subtitle" class="text-[10px] font-bold uppercase tracking-widest text-gray-400 mt-1">
                            — CYCLE • REFERENCE #—
                        </p>
                    </div>
                </div>
                <button onclick="closeModal()" aria-label="Close"
                        class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-gray-100 active:bg-gray-200 transition-colors shrink-0 mt-0.5">
                    <svg class="w-5 h-5 text-zinc-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M18 6 6 18M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- BODY --}}
        <div class="px-5 sm:px-8 py-5 sm:py-7 flex flex-col sm:grid sm:grid-cols-2 gap-4 sm:gap-5">

            {{-- Employee Information --}}
            <div class="bg-white border border-zinc-100 rounded-[18px] sm:rounded-[20px] p-4 sm:p-5 shadow-sm space-y-3 sm:space-y-4">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Employee Information</p>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-400">Name</span>
                        <span id="modal-emp-name" class="text-sm font-black text-zinc-900">—</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-400">Role</span>
                        <span id="modal-emp-role"
                              class="text-[10px] font-black uppercase tracking-wider bg-zinc-100 text-zinc-700 px-3 py-1 rounded-lg">—</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-400">Account ID</span>
                        <span id="modal-emp-account" class="text-sm font-bold text-zinc-900 tracking-widest">—</span>
                    </div>
                </div>
            </div>

            {{-- Payment Breakdown --}}
            <div class="bg-white border border-zinc-100 rounded-[18px] sm:rounded-[20px] p-4 sm:p-5 shadow-sm space-y-3 sm:space-y-4">
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">Payment Breakdown</p>
                <div class="flex items-center justify-between pt-1">
                    <span class="text-sm font-black text-zinc-900">Net Salary</span>
                    <span id="modal-net-salary" class="text-xl sm:text-2xl font-black text-purple-600 font-mono">—</span>
                </div>
            </div>

            {{-- Encrypted Preview — full width di mobile --}}
            <div class="sm:col-span-2 bg-gray-100/80 rounded-[18px] sm:rounded-[20px] flex flex-col items-center justify-center p-6 sm:p-8 min-h-30 sm:min-h-40">
                <svg class="w-10 h-10 sm:w-14 sm:h-14 text-gray-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                    <path d="M14 2v6h6M8 13h8M8 17h5"/>
                </svg>
                <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 text-center leading-loose">
                    Encrypted Digital Slip Preview<br>Download For Full Analysis
                </p>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="px-5 sm:px-8 pb-6 sm:pb-8 grid grid-cols-2 gap-3 sm:gap-4">
            <button type="button" onclick="window.print()"
                    class="flex items-center justify-center gap-2 sm:gap-3 h-12 sm:h-14 bg-gray-100 rounded-xl sm:rounded-2xl hover:bg-gray-200 active:scale-95 transition-all duration-150">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-zinc-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/>
                    <rect x="6" y="14" width="12" height="8" rx="1"/>
                </svg>
                <span class="text-[10px] sm:text-[11px] font-black uppercase tracking-widest text-zinc-700">Print</span>
            </button>
            <button type="button"
                    class="flex items-center justify-center gap-2 sm:gap-3 h-12 sm:h-14 bg-purple-600 rounded-xl sm:rounded-2xl shadow-[0px_10px_15px_-3px_rgba(147,51,234,0.30)] hover:bg-purple-700 active:scale-95 transition-all duration-150">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M12 3v13M6 11l6 6 6-6M3 19h18"/>
                </svg>
                <span class="text-[10px] sm:text-[11px] font-black uppercase tracking-widest text-white">Download</span>
            </button>
        </div>
    </div>
</div>

{{-- ===== MODAL JS ===== --}}
<script>
    const modal      = document.getElementById('salary-modal');
    const modalPanel = document.getElementById('modal-panel');
    const isMobile   = () => window.innerWidth < 640;

    function openModal(slip, employee) {
        document.getElementById('modal-subtitle').textContent =
            slip.cycle + ' CYCLE \u2022 REFERENCE #' + slip.ref;
        document.getElementById('modal-emp-name').textContent    = employee.name;
        document.getElementById('modal-emp-role').textContent    = employee.role.toUpperCase();
        document.getElementById('modal-emp-account').textContent = '**** ' + employee.account_id;

        const amount    = parseFloat(slip.amount);
        const formatted = '$' + amount.toLocaleString('en-US', {
            minimumFractionDigits: amount % 1 !== 0 ? 1 : 0,
            maximumFractionDigits: 2
        });
        document.getElementById('modal-net-salary').textContent = formatted;

        /* FIX #4: Karena kita membuang 'flex' dari inisialisasi awal, kita harus menambahkannya saat modal dibuka */
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                if (isMobile()) {
                    /* Bottom sheet slide up */
                    modalPanel.classList.remove('translate-y-full', 'opacity-0');
                    modalPanel.classList.add('translate-y-0', 'opacity-100');
                } else {
                    /* Centered scale in */
                    modalPanel.classList.remove('scale-95', 'opacity-0', 'sm:scale-95');
                    modalPanel.classList.add('scale-100', 'opacity-100');
                }
            });
        });
    }

    function closeModal() {
        if (isMobile()) {
            modalPanel.classList.remove('translate-y-0', 'opacity-100');
            modalPanel.classList.add('translate-y-full', 'opacity-0');
        } else {
            modalPanel.classList.remove('scale-100', 'opacity-100');
            modalPanel.classList.add('scale-95', 'opacity-0');
        }
        setTimeout(() => {
            /* FIX #5: Menghapus 'flex' lagi dan menambahkan 'hidden' saat ditutup */
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }, 200);
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
    });
</script>

@endsection