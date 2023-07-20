<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UsersInfoController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('usersinfo', [UsersInfoController::class, 'index']);
    Route::post('usersinfo', [UsersInfoController::class, 'store']);
    Route::get('usersinfo/{id}', [UsersInfoController::class, 'show']);
    Route::get('usersinfo/{id}/edit', [UsersInfoController::class, 'edit']);
    Route::put('usersinfo/{id}/edit', [UsersInfoController::class, 'update']);
    Route::delete('usersinfo/{id}/delete', [UsersInfoController::class, 'destroy']);
});

Route::post('/auth/register', [UserController::class,'create']);
Route::post('/auth/login', [UserController::class,'login']);
Route::post('/auth/logout', [UserController::class,'logout']);

