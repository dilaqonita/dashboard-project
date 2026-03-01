<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('staff.dashboard');
})->name('dashboard');

// Penambahan .index pada semua nama route agar sesuai dengan app.blade.php
Route::get('/evaluations', function () {
    return view('staff.evaluation'); 
})->name('evaluations.index');

Route::get('/payroll', function () {
    $payslips = [
        ['id'=>1,'period'=>'February 2026','released'=>'2026-02-01','amount'=>2100.5, 'cycle'=>'FEBRUARY 2026','ref'=>'H1'],
        ['id'=>2,'period'=>'January 2026', 'released'=>'2026-01-01','amount'=>2050.0, 'cycle'=>'JANUARY 2026', 'ref'=>'H2'],
        ['id'=>3,'period'=>'December 2025','released'=>'2025-12-01','amount'=>2150.0, 'cycle'=>'DECEMBER 2025','ref'=>'H3'],
        ['id'=>4,'period'=>'November 2025','released'=>'2025-11-01','amount'=>1980.0, 'cycle'=>'NOVEMBER 2025','ref'=>'H4'],
    ];
    $employee   = ['name'=>'John Lennon','role'=>'Barista','account_id'=>'5621'];
    $lastAmount = collect($payslips)->first()['amount'] ?? 0;
    return view('staff.payroll', compact('payslips','employee','lastAmount'));
})->name('payroll.index');

Route::get('/food-allowance', function () {
    return view('staff.food-allowance');
})->name('food-allowance.index');

Route::get('/overtime', function () {
    $overtimes = [
        ['date'=>'2026-02-04','duration'=>'3h',  'description'=>'Stock take and inventory audit','status'=>'pending'],
        ['date'=>'2026-01-28','duration'=>'1.5h', 'description'=>'Kitchen deep clean after closing.','status'=>'approved'],
    ];
    $thisMonthOT = '12.5';
    return view('staff.overtime', compact('overtimes','thisMonthOT'));
})->name('overtime.index');

// Route POST biasanya menggunakan nama .store
Route::post('/overtime', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'work_date' => 'required|date',
        'duration'  => 'required|numeric|min:0.5|max:24',
        'reason'    => 'required|string|max:1000',
        'proof'     => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
    ]);
    return response()->json(['success'=>true,'message'=>'Overtime request submitted.']);
})->name('overtime.store');

Route::get('/settings', function () {
    return view('staff.settings');
})->name('settings.index');