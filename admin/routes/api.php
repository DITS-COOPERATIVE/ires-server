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
    Route::get('customers', [UserController::class, 'index']);
    Route::post('customers', [UserController::class, 'store']);
    Route::get('customers/{id}', [UserController::class, 'show']);
    Route::put('customers/{id}', [UserController::class, 'update']);
    Route::delete('customers/{id}', [UserController::class, 'destroy']);

    //PRODUCTS
    Route::get('products', [ProductController::class, 'index']);
    Route::post('products', [ProductController::class, 'store']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::put('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);
});



