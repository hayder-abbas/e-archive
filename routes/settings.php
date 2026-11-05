<?php

use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\SecurityController;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', '/settings/profile');

    Route::prefix('settings/')->group(function () {
        Route::controller(ProfileController::class)->group(function () {
            Route::get('profile', 'edit')->name('profile.edit');
            Route::patch('profile', 'update')->name('profile.update');
            Route::delete('profile', 'destroy')->name('profile.destroy');
        });

        Route::controller(SecurityController::class)->group(function () {
            Route::get('security', 'edit')->middleware(RequirePassword::class)->name('security.edit');
            Route::put('password', 'update')->middleware('throttle:6,1')->name('user-password.update');
        });

        Route::inertia('appearance', 'settings/Appearance')->name('appearance.edit');

        Route::controller(UserController::class)->group(function () {
            Route::get('users', 'index')->name('users');
            Route::patch('users/{user}/set-admin', 'setAsAdmin')->name('users.set-admin');
            Route::patch('users/{user}/set-user', 'setAsUser')->name('users.set-user');
            Route::delete('users/{user}', 'destroy')->name('users.destroy');
        });
    });
});

Route::get('.well-known/passkey-endpoints', function () {
    return response()->json([
        'enroll' => route('security.edit'),
        'manage' => route('security.edit'),
    ]);
})->name('well-known.passkeys');
