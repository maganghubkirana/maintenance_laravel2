<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MaintenanceController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class,'showLogin'])->name('login');
    Route::post('/login', [AuthController::class,'login'])->name('login.store');
    Route::get('/register', [AuthController::class,'showRegister'])->name('register');
    Route::post('/register', [AuthController::class,'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class,'logout'])->name('logout');
    Route::get('/', fn() => redirect()->route('dashboard'));

    // Dashboard
    Route::get('/dashboard', [DashboardController::class,'index'])
        ->middleware('permission:dashboard')
        ->name('dashboard');

    // Maintenance
    Route::middleware('permission:maintenance')->group(function () {
        Route::get('/maintenance', [MaintenanceController::class,'index'])->name('maintenance.index');
        Route::post('/maintenance', [MaintenanceController::class,'store'])->name('maintenance.store');
        Route::post('/maintenance/{maintenance}/status', [MaintenanceController::class,'updateStatus'])->name('maintenance.status');
    });

    // History
    Route::get('/history', [MaintenanceController::class,'history'])
        ->middleware('permission:history')
        ->name('history');

    // Equipment (GANTI middleware 'role:ADMIN' menjadi 'permission:equipment')
    Route::middleware('permission:equipment')->group(function () {
        Route::get('/equipment', [EquipmentController::class,'index'])->name('equipment.index');
        Route::post('/equipment', [EquipmentController::class,'store'])->name('equipment.store');
        Route::delete('/equipment/{equipment}', [EquipmentController::class,'destroy'])->name('equipment.destroy');
    });

    // User Management (Khusus yang memiliki permission 'users')
    Route::middleware('permission:users')->group(function () {
        Route::resource('users', UserController::class)->only(['index', 'store', 'destroy']);
        Route::put('/users/{user}/permissions', [UserController::class, 'updatePermissions'])->name('users.permissions');
    });
});