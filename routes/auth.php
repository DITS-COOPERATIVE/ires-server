<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::middleware('guest')->group(function () {
    Route::POST('auth/register', [AuthController::class, 'createUser']);
    Route::POST('auth/login', [AuthController::class, 'loginUser']);
});
