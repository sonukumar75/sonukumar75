<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\LabTestController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('welcome');

Route::middleware(['auth', 'tenant'])->group(function (): void {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::middleware('role:owner,admin')->group(function (): void {
        Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');
        Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');
    });

    Route::middleware('role:owner,admin,lab_manager')->group(function (): void {
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/instruments', [InstrumentController::class, 'index'])->name('instruments.index');
        Route::post('/instruments', [InstrumentController::class, 'store'])->name('instruments.store');
        Route::post('/instruments/{instrument}/calibrate', [InstrumentController::class, 'calibrate'])->name('instruments.calibrate');
    });

    Route::middleware('role:owner,admin,lab_manager,technician')->group(function (): void {
        Route::get('/lab-tests', [LabTestController::class, 'index'])->name('lab-tests.index');
        Route::post('/lab-tests', [LabTestController::class, 'store'])->name('lab-tests.store');
        Route::patch('/lab-tests/{labTest}/result', [LabTestController::class, 'updateResult'])->name('lab-tests.result');
    });
});
