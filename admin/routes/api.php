<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\Api\UsersInfoController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// LOGIN
Route::post('/auth/register', [UserController::class,'create']);
Route::post('/auth/login', [UserController::class,'login']);
Route::post('/auth/logout', [UserController::class,'logout']);


Route::middleware(['auth:sanctum'])->group(function () {

    //USERS
    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::get('users/{id}/edit', [UserController::class, 'edit']);
    Route::put('users/{id}/update', [UserController::class, 'update']);
    Route::delete('users/{id}/delete', [UserController::class, 'destroy']);

    //PRODUCTS
    Route::get('products', [ProductController::class, 'index']);
    Route::post('products', [ProductController::class, 'store']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::get('products/{id}/edit', [ProductController::class, 'edit']);
    Route::put('products/{id}/update', [ProductController::class, 'update']);
    Route::delete('products/{id}/delete', [ProductController::class, 'destroy']);
});



