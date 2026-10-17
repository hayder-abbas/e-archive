<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\BoxController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\Settings\SetLocaleContruller;
use App\Models\Document;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::resource('boxes', BoxController::class);
    Route::resource('entities', EntityController::class);
    Route::resource('documents', DocumentController::class);

    Route::delete('/documents/{document}/force-delete', [DocumentController::class, 'forceDelete'])
        ->name('document.force-delete')->withTrashed();
    Route::patch('/documents/{document}/restore', [DocumentController::class, 'restore'])
        ->name('document.restore')->withTrashed();

    Route::resource('borrows', BorrowController::class);

    Route::controller(AuditLogController::class)->group(function () {
        Route::get('/audit-logs', 'index')->name('audit-logs.index');
        Route::post('/audit-logs', 'store')->name('audit-logs.store');
        Route::delete('/audit-logs', 'destroy')->name('audit-logs.destroy');
    });

    Route::put('/settings/locale', SetLocaleContruller::class)->name('settings.local');

    Route::inertia('trash', 'Trash', [
        'documents' => Document::onlyTrashed()
            ->with(['box:id,box_number'])
            ->paginate(20)
            ->toResourceCollection()
    ])->name('trash');
});


require __DIR__ . '/settings.php';
