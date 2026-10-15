<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\BoxController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\Settings\SetLocaleContruller;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::resource('boxes', BoxController::class);
    Route::resource('entities', EntityController::class);
    Route::resource('documents', DocumentController::class);
    Route::resource('borrows', BorrowController::class);

    Route::controller(AuditLogController::class)->group(function () {
        Route::get('/audit-logs', 'index')->name('audit-logs.index');
        Route::post('/audit-logs', 'store')->name('audit-logs.store');
        Route::delete('/audit-logs', 'destroy')->name('audit-logs.destroy');
    });
});

Route::put('/settings/locale', SetLocaleContruller::class)->name('settings.local');

require __DIR__ . '/settings.php';
