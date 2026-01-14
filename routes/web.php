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
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/reservations', [HomeController::class, 'storeReservation'])->name('reservations.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::middleware('role:admin,staff')->group(function () {
            Route::resource('reservations', ReservationController::class)->only(['index', 'update', 'destroy']);
        });

        Route::middleware('role:admin')->group(function () {
            Route::resource('rooms', RoomController::class)->except(['show']);
            Route::resource('reviews', ReviewController::class)->except(['show']);
            Route::resource('gallery', GalleryController::class)->except(['show']);
            Route::resource('landmarks', LandmarkController::class)->except(['show']);
            Route::get('content', [ContentController::class, 'edit'])->name('content.edit');
            Route::post('content', [ContentController::class, 'update'])->name('content.update');
            
            // Sales & Reports
            Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');
            Route::get('invoices/{reservation}', [InvoiceController::class, 'show'])->name('invoices.show');
        });
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
