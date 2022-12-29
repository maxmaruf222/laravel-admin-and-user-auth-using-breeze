<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\PasswordController as AdminPasswordController;
use App\Http\Controllers\Admin\Auth\NewPasswordController as AdminNewPasswordController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController as AdminVerifyEmailController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController as AdminRegisteredUserController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController as AdminPasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController as AdminConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController as AdminAuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController as AdminEmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController as AdminEmailVerificationNotificationController;

Route::prefix('/admin')->name('admin.')->middleware('admin.guest:admin')->group(function () {
    Route::get('register', [AdminRegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [AdminRegisteredUserController::class, 'store']);

    Route::get('login', [AdminAuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AdminAuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [AdminPasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [AdminPasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [AdminNewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [AdminNewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::prefix('/admin')->name('admin.')->middleware('admin.auth:admin')->group(function(){
    Route::get('verify-email', [AdminEmailVerificationPromptController::class, '__invoke'])
    ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [AdminVerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [AdminEmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [AdminConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [AdminConfirmablePasswordController::class, 'store']);

    Route::put('password', [AdminPasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AdminAuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});


