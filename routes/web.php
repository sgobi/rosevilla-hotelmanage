<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\LandmarkController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/reservations', [HomeController::class, 'storeReservation'])->name('reservations.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/notifications/mark-read', [DashboardController::class, 'markAllRead'])->name('notifications.markRead');
    Route::get('/notifications/{id}/read', [DashboardController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/notifications/fetch', [DashboardController::class, 'fetchNotifications'])->name('notifications.fetch');

    Route::prefix('admin')->name('admin.')->group(function () {
        
        // Staff & Admin
        Route::middleware('role:admin,staff')->group(function () {
            Route::resource('reservations', ReservationController::class)->only(['index', 'update', 'destroy']);
            Route::resource('reviews', ReviewController::class)->except(['show']);
        });

        // Admin, Accountant, & Staff (Invoices)
        Route::middleware('role:admin,accountant,staff')->group(function () {
            Route::get('invoices/{reservation}', [InvoiceController::class, 'show'])->name('invoices.show');
        });

        // Accountant & Admin (Reports)
        Route::middleware('role:admin,accountant')->group(function () {
            Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
            Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');
        });

        // Admin Only
        Route::middleware('role:admin')->group(function () {
            Route::resource('rooms', RoomController::class)->except(['show']);
            Route::resource('gallery', GalleryController::class)->except(['show']);
            Route::resource('landmarks', LandmarkController::class)->except(['show']);
            Route::get('content', [ContentController::class, 'edit'])->name('content.edit');
            Route::post('content', [ContentController::class, 'update'])->name('content.update');
            Route::resource('users', UserController::class)->except(['show']);
        });
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
