<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\TicketController;


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
    | Logout & Root
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/select-role', [AuthController::class, 'selectRole'])
        ->name('select-role');


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
    | Tickets Module
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:tickets')->group(function () {

        // Master CRUD Tiket
        Route::resource('tickets', TicketController::class);

        // Aksi Tambahan Tiket (Assign, Status Update, & Logs)
        Route::patch('/tickets/{id}/assign', [TicketController::class, 'assignTechnician'])
            ->name('tickets.assign');

        Route::patch('/tickets/{id}/status', [TicketController::class, 'updateStatus'])
            ->name('tickets.status');

        Route::post('/tickets/{id}/logs', [TicketController::class, 'addLog'])
            ->name('tickets.addLog');

        // Penggunaan Sparepart di dalam Tiket
        Route::post('/tickets/{ticket}/spareparts', [TicketController::class, 'addSparepart'])
            ->name('tickets.spareparts.store');

        Route::delete('/tickets/{ticket}/spareparts/{sparepart}', [TicketController::class, 'removeSparepart'])
            ->name('tickets.spareparts.destroy');

    });


    /*
    |--------------------------------------------------------------------------
    | Maintenance Module
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:maintenance')->group(function () {

        Route::get('/maintenance', [MaintenanceController::class, 'index'])
            ->name('maintenance.index');

        Route::post('/maintenance', [MaintenanceController::class, 'store'])
            ->name('maintenance.store');

        Route::post('/maintenance/{maintenance}/status', [MaintenanceController::class, 'updateStatus'])
            ->name('maintenance.status');

    });


    /*
    |--------------------------------------------------------------------------
    | Maintenance History & Export
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:history')->group(function () {

        Route::get('/history', [MaintenanceController::class, 'history'])
            ->name('history');

        Route::get('/history/export/pdf', [MaintenanceController::class, 'exportPdf'])
            ->name('history.export.pdf');

        Route::get('/history/export/excel', [MaintenanceController::class, 'exportExcel'])
            ->name('history.export.excel');

    });


    /*
    |--------------------------------------------------------------------------
    | Sparepart Inventory
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:spareparts')->group(function () {

        Route::resource('spareparts', SparepartController::class);

    });


    /*
    |--------------------------------------------------------------------------
    | Equipment
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:equipment')->group(function () {

        Route::get('/equipment', [EquipmentController::class, 'index'])
            ->name('equipment.index');

        Route::post('/equipment', [EquipmentController::class, 'store'])
            ->name('equipment.store');

        Route::delete('/equipment/{equipment}', [EquipmentController::class, 'destroy'])
            ->name('equipment.destroy');

    });


    /*
    |--------------------------------------------------------------------------
    | User Management
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:users')->group(function () {

        Route::resource('users', UserController::class)->only([
            'index', 'store', 'destroy'
        ]);

        Route::put('/users/{user}/permissions', [UserController::class, 'updatePermissions'])
            ->name('users.permissions');

    });

});