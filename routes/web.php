<?php

use App\Http\Controllers\BatchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MicrogreenController;
use App\Http\Controllers\NotificationScheduleController;
use App\Http\Controllers\ObservationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'batches', 'as' => 'batches.'], function () {
        Route::get('/', [BatchController::class, 'index'])->name('index');
        Route::get('/create', [BatchController::class, 'create'])->name('create');
        Route::post('/', [BatchController::class, 'store'])->name('store');
        Route::get('/{batch}/edit', [BatchController::class, 'edit'])->name('edit');
        Route::patch('/{batch}', [BatchController::class, 'update'])->name('update');
        Route::delete('/{batch}', [BatchController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'microgreen', 'as' => 'microgreen.'], function () {
        Route::get('/', [MicrogreenController::class, 'index'])->name('index');
        Route::get('/create', [MicrogreenController::class, 'create'])->name('index');
        Route::post('/', [MicrogreenController::class, 'store'])->name('store');
        Route::get('/{microgreen}/edit', [MicrogreenController::class, 'edit'])->name('edit');
        Route::patch('/{microgreen}', [MicrogreenController::class, 'update'])->name('update');
        Route::delete('/{microgreen}', [MicrogreenController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'observations', 'as' => 'observations.'], function () {
        Route::get('/', [ObservationController::class, 'index'])->name('index');
        Route::get('/create', [ObservationController::class, 'create'])->name('create');
        Route::post('/', [ObservationController::class, 'store'])->name('store');
        Route::get('/{observation}/edit', [ObservationController::class, 'edit'])->name('edit');
        Route::patch('/{observation}', [ObservationController::class, 'update'])->name('update');
        Route::delete('/{observation}', [ObservationController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'notifications', 'as' => 'notifications.'], function () {
        Route::group(['prefix' => 'schedule', 'as' => 'schedule.'], function () {
            Route::get('/', [NotificationScheduleController::class, 'index'])->name('index');
            Route::get('/create', [NotificationScheduleController::class, 'create'])->name('create');
            Route::post('/', [NotificationScheduleController::class, 'store'])->name('store');
            Route::get('/{schedule}/edit', [NotificationScheduleController::class, 'edit'])->name('edit');
            Route::patch('/{schedule}', [NotificationScheduleController::class, 'update'])->name('update');
            Route::delete('/{schedule}', [NotificationScheduleController::class, 'destroy'])->name('destroy');
        });
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
