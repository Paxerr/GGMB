<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeeRateController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\ResidentPortalController;
use App\Http\Controllers\TechPortalController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

// Tuyến đường công khai (Xác thực đăng nhập)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Tuyến đường yêu cầu đăng nhập
Route::middleware(['auth'])->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Phân hệ Quản trị chung (Manager, Support)
    Route::middleware(['role:MANAGER,SUPPORT'])->group(function (): void {
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Tòa nhà & Tầng
        Route::get('/buildings', [BuildingController::class, 'index'])->name('buildings.index');
        Route::get('/buildings/create', [BuildingController::class, 'create'])->name('buildings.create');
        Route::post('/buildings', [BuildingController::class, 'store'])->name('buildings.store');
        Route::get('/buildings/{building}/edit', [BuildingController::class, 'edit'])->name('buildings.edit');
        Route::put('/buildings/{building}', [BuildingController::class, 'update'])->name('buildings.update');
        Route::delete('/buildings/{building}', [BuildingController::class, 'destroy'])->name('buildings.destroy');
        Route::post('/buildings/{building}/floors', [BuildingController::class, 'storeFloor'])->name('buildings.floors.store');
        Route::put('/floors/{floor}', [BuildingController::class, 'updateFloor'])->name('floors.update');
        Route::delete('/floors/{floor}', [BuildingController::class, 'destroyFloor'])->name('floors.destroy');

        // Căn hộ
        Route::get('/apartments', [ApartmentController::class, 'index'])->name('apartments.index');
        Route::get('/apartments/create', [ApartmentController::class, 'create'])->name('apartments.create');
        Route::post('/apartments', [ApartmentController::class, 'store'])->name('apartments.store');
        Route::get('/apartments/{apartment}', [ApartmentController::class, 'show'])->name('apartments.show');
        Route::get('/apartments/{apartment}/edit', [ApartmentController::class, 'edit'])->name('apartments.edit');
        Route::put('/apartments/{apartment}', [ApartmentController::class, 'update'])->name('apartments.update');
        Route::patch('/apartments/{apartment}/status', [ApartmentController::class, 'updateStatus'])->name('apartments.update-status');

        // Cư dân
        Route::get('/residents', [ResidentController::class, 'index'])->name('residents.index');
        Route::get('/residents/create', [ResidentController::class, 'create'])->name('residents.create');
        Route::post('/residents', [ResidentController::class, 'store'])->name('residents.store');
        Route::get('/residents/{id}', [ResidentController::class, 'show'])->name('residents.show');
        Route::get('/residents/{id}/edit', [ResidentController::class, 'edit'])->name('residents.edit');
        Route::put('/residents/{id}', [ResidentController::class, 'update'])->name('residents.update');
        Route::patch('/residents/{id}/status', [ResidentController::class, 'updateStatus'])->name('residents.update-status');

        // Phương tiện
        Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
        Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
        Route::get('/vehicles/{id}', [VehicleController::class, 'show'])->name('vehicles.show');
        Route::get('/vehicles/{id}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
        Route::put('/vehicles/{id}', [VehicleController::class, 'update'])->name('vehicles.update');
        Route::get('/vehicles/{id}/cancel', [VehicleController::class, 'cancel'])->name('vehicles.cancel');
        Route::post('/vehicles/{id}/cancel', [VehicleController::class, 'confirmCancel'])->name('vehicles.confirm-cancel');

        // Điện nước & Hóa đơn & Biểu phí
        Route::get('/utilities', [UtilityController::class, 'index'])->name('utilities.index');
        Route::post('/utilities/correct', [UtilityController::class, 'correct'])->name('utilities.correct');
        Route::post('/utilities/first-time', [UtilityController::class, 'firstTime'])->name('utilities.first-time');

        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
        Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
        Route::post('/invoices/{id}/collect', [InvoiceController::class, 'collect'])->name('invoices.collect');
        Route::post('/invoices/{id}/cancel', [InvoiceController::class, 'cancel'])->name('invoices.cancel');

        Route::get('/fee-rates', [FeeRateController::class, 'index'])->name('fee-rates.index');
        Route::get('/fee-rates/create', [FeeRateController::class, 'create'])->name('fee-rates.create');
        Route::post('/fee-rates', [FeeRateController::class, 'store'])->name('fee-rates.store');
        Route::get('/fee-rates/{id}', [FeeRateController::class, 'show'])->name('fee-rates.show');
        Route::get('/fee-rates/{id}/edit', [FeeRateController::class, 'edit'])->name('fee-rates.edit');
        Route::put('/fee-rates/{id}', [FeeRateController::class, 'update'])->name('fee-rates.update');
        Route::get('/fee-rates/{id}/deactivate', [FeeRateController::class, 'deactivate'])->name('fee-rates.deactivate');
        Route::post('/fee-rates/{id}/deactivate', [FeeRateController::class, 'confirmDeactivate'])->name('fee-rates.confirm-deactivate');
        Route::get('/fee-rates/{id}/activate', [FeeRateController::class, 'activate'])->name('fee-rates.activate');
        Route::post('/fee-rates/{id}/activate', [FeeRateController::class, 'confirmActivate'])->name('fee-rates.confirm-activate');
        Route::get('/fee-rates/{id}/rates/create', [FeeRateController::class, 'createRate'])->name('fee-rates.rates.create');
        Route::post('/fee-rates/{id}/rates', [FeeRateController::class, 'storeRate'])->name('fee-rates.rates.store');

        // Yêu cầu & Thông báo
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
        Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');
        Route::post('/tickets/{id}/assign', [TicketController::class, 'assign'])->name('tickets.assign');
        Route::post('/tickets/{id}/verify', [TicketController::class, 'verify'])->name('tickets.verify');
        Route::post('/tickets/{id}/cancel', [TicketController::class, 'cancel'])->name('tickets.cancel');

        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
        Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
        Route::put('/notifications/{id}', [NotificationController::class, 'update'])->name('notifications.update');

        // Quản trị tài khoản nhân sự (Chỉ Quản lý - MANAGER)
        Route::middleware(['role:MANAGER'])->group(function (): void {
            Route::get('/accounts', [AccountController::class, 'index'])->name('accounts.index');
            Route::get('/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
            Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store');
            Route::get('/accounts/{id}', [AccountController::class, 'show'])->name('accounts.show');
            Route::get('/accounts/{id}/edit', [AccountController::class, 'edit'])->name('accounts.edit');
            Route::put('/accounts/{id}', [AccountController::class, 'update'])->name('accounts.update');
            Route::get('/accounts/{id}/lock', [AccountController::class, 'lock'])->name('accounts.lock');
            Route::post('/accounts/{id}/lock', [AccountController::class, 'confirmLock'])->name('accounts.confirm-lock');
            Route::get('/accounts/{id}/unlock', [AccountController::class, 'unlock'])->name('accounts.unlock');
            Route::post('/accounts/{id}/unlock', [AccountController::class, 'confirmUnlock'])->name('accounts.confirm-unlock');
        });
    });

    // Cổng cư dân (Resident Portal)
    Route::prefix('portal')->name('portal.')->middleware(['role:RESIDENT,MANAGER'])->group(function (): void {
        Route::get('/', [ResidentPortalController::class, 'dashboard'])->name('dashboard');
        Route::get('/invoices', [ResidentPortalController::class, 'invoices'])->name('invoices');
        Route::get('/tickets', [ResidentPortalController::class, 'tickets'])->name('tickets');
        Route::post('/tickets', [ResidentPortalController::class, 'ticketStore'])->name('tickets.store');
        Route::get('/tickets/{id}', [ResidentPortalController::class, 'ticketShow'])->name('tickets.show');
        Route::post('/tickets/{id}/reply', [ResidentPortalController::class, 'ticketReply'])->name('tickets.reply');
        Route::get('/notifications/{id}', [ResidentPortalController::class, 'notificationShow'])->name('notifications.show');
        Route::get('/profile', [ResidentPortalController::class, 'profile'])->name('profile');
        Route::get('/profile/edit', [ResidentPortalController::class, 'profileEdit'])->name('profile.edit');
        Route::post('/profile', [ResidentPortalController::class, 'profileUpdate'])->name('profile.update');
    });

    // Cổng kỹ thuật (Technician Portal)
    Route::prefix('tech')->name('tech.')->middleware(['role:TECHNICIAN,MANAGER'])->group(function (): void {
        Route::get('/', [TechPortalController::class, 'tasks'])->name('dashboard');
        Route::get('/tasks', [TechPortalController::class, 'tasks'])->name('tasks');
        Route::get('/tasks/{id}', [TechPortalController::class, 'taskShow'])->name('tasks.show');
        Route::post('/tasks/{id}/complete', [TechPortalController::class, 'taskComplete'])->name('tasks.complete');
        Route::get('/utilities', [TechPortalController::class, 'utilities'])->name('utilities');
        Route::post('/utilities', [TechPortalController::class, 'utilitiesStore'])->name('utilities.store');
    });
});
