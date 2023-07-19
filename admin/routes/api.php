<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UsersInfoController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * CRUD Routes
 */

// READ
Route::get('usersinfo', [UsersInfoController::class, 'index']);

// CREATE
Route::post('usersinfo', [UsersInfoController::class, 'store']);

// READ
Route::get('usersinfo/{id}', [UsersInfoController::class, 'show']);

// UPDATE
Route::get('usersinfo/{id}/edit', [UsersInfoController::class, 'edit']);

// UPDATE
Route::put('usersinfo/{id}/edit', [UsersInfoController::class, 'update']);

// DELETE
Route::delete('usersinfo/{id}/delete', [UsersInfoController::class, 'destroy']);

/**
 * Login and Register Routes
 */
//REGISTER USER
Route::post('/auth/register', [UserController::class,'create']);

//LOGIN USER
Route::post('/auth/login', [UserController::class,'login']);

//LOGOUT USER
Route::post('/auth/logout', [UserController::class,'logout']);