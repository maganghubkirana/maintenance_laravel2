<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MaintenanceController;


/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.store');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.store');

});


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | Root
    |--------------------------------------------------------------------------
    */

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });


    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('permission:dashboard')
        ->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Maintenance
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:maintenance')->group(function () {

        // Halaman Maintenance Request
        Route::get('/maintenance', [MaintenanceController::class, 'index'])
            ->name('maintenance.index');

        // Membuat Maintenance Request
        Route::post('/maintenance', [MaintenanceController::class, 'store'])
            ->name('maintenance.store');

        // Update Status Maintenance
        Route::post(
            '/maintenance/{maintenance}/status',
            [MaintenanceController::class, 'updateStatus']
        )->name('maintenance.status');

    });


    /*
    |--------------------------------------------------------------------------
    | Maintenance History
    |--------------------------------------------------------------------------
    */

    // Halaman History
    Route::get('/history', [MaintenanceController::class, 'history'])
        ->middleware('permission:history')
        ->name('history');


    /*
    |--------------------------------------------------------------------------
    | Export History PDF
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/history/export/pdf',
        [MaintenanceController::class, 'exportPdf']
    )
        ->middleware('permission:history')
        ->name('history.export.pdf');


    /*
    |--------------------------------------------------------------------------
    | Export History Excel
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/history/export/excel',
        [MaintenanceController::class, 'exportExcel']
    )
        ->middleware('permission:history')
        ->name('history.export.excel');


    /*
    |--------------------------------------------------------------------------
    | Equipment
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:equipment')->group(function () {

        // Daftar Equipment
        Route::get('/equipment', [EquipmentController::class, 'index'])
            ->name('equipment.index');

        // Tambah Equipment
        Route::post('/equipment', [EquipmentController::class, 'store'])
            ->name('equipment.store');

        // Hapus Equipment
        Route::delete(
            '/equipment/{equipment}',
            [EquipmentController::class, 'destroy']
        )->name('equipment.destroy');

    });


    /*
    |--------------------------------------------------------------------------
    | User Management
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:users')->group(function () {

        // User List
        Route::resource('users', UserController::class)
            ->only([
                'index',
                'store',
                'destroy'
            ]);

        // Update Permission User
        Route::put(
            '/users/{user}/permissions',
            [UserController::class, 'updatePermissions']
        )->name('users.permissions');

    });

});


/*
|--------------------------------------------------------------------------
| Role Selection
|--------------------------------------------------------------------------
|
| Digunakan setelah login apabila user perlu memilih role.
|
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/select-role',
        [AuthController::class, 'selectRole']
    )->name('select-role');

});