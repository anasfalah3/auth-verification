<?php

use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\PasswordResetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/email-verification', [EmailVerificationController::class, 'sendVerificationEmail']);
Route::get('/email-verification/{token}', [EmailVerificationController::class, 'verifyEmail']);

Route::post('/password_reset', [PasswordResetController::class, 'sendPasswordResetEmail']);
Route::get('/password_reset/{token}', [PasswordResetController::class, 'PasswordResetEmail']);