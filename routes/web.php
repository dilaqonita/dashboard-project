<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\FoodAllowanceController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\SettingsController;

Route::get('/',              [DashboardController::class,    'index'])->name('dashboard');
Route::get('/evaluations',   [EvaluationController::class,   'index'])->name('evaluations.index');
Route::get('/payroll',       [PayrollController::class,      'index'])->name('payroll.index');
Route::get('/food-allowance',[FoodAllowanceController::class,'index'])->name('food-allowance.index');
Route::get('/overtime',      [OvertimeController::class,     'index'])->name('overtime.index');
Route::post('/overtime',     [OvertimeController::class,     'store'])->name('overtime.store');
Route::get('/settings',      [SettingsController::class,     'index'])->name('settings.index');