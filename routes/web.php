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

    Route::resource('entities', EntityController::class);
    Route::resource('boxes', BoxController::class)->except('destroy');

    Route::resource('documents', DocumentController::class)->except('destroy');
    Route::controller(DocumentController::class)->group(function () {
        Route::get('/documents/{document}/show-file', 'showFile')
            ->name('documents.show-file');
        Route::get('/revokeds', 'revokeds')
            ->name('revokeds');
        Route::patch('/documents/{document}/revoke', 'revoke')
            ->name('document.revoke');
        Route::patch('/documents/{document}/reinstate', 'reinstate')
            ->name('document.reinstate');
    });

    Route::resource('borrows', BorrowController::class);

    Route::resource('audit-logs', AuditLogController::class)
        ->only(['index', 'store', 'destroy']);

    Route::put('/settings/locale', SetLocaleContruller::class)->name('settings.local');
});

require __DIR__ . '/settings.php';
