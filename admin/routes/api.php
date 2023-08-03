<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\Api\UsersInfoController;
use App\Http\Controllers\api\TransactionController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// LOGIN
Route::post('/auth/register', [UserController::class,'create']);
Route::post('/auth/login', [UserController::class,'login']);
Route::post('/auth/logout', [UserController::class,'logout']);


Route::middleware(['auth:sanctum'])->group(function () {

    //USERS
    Route::get('customers', [CustomerController::class, 'index']);
    Route::post('customers/add', [CustomerController::class, 'store']);
    Route::get('customers/{id}', [CustomerController::class, 'show']);
    Route::put('customers/{id}', [CustomerController::class, 'update']);
    Route::delete('customers/{id}', [CustomerController::class, 'destroy']);

    //PRODUCTS
    Route::get('products', [ProductController::class, 'index']);
    Route::post('products', [ProductController::class, 'store']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::put('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);

    //ORDERS
    Route::get('orders', [OrderController::class, 'index']);
    Route::post('orders', [OrderController::class, 'store']);
    Route::get('orders/{id}', [OrderController::class, 'show']);
    Route::delete('orders/{id}', [OrderController::class, 'destroy']);

    //TRANSACTIONS
    Route::get('transactions', [TransactionController::class, 'index']);
    Route::post('transactions', [TransactionController::class, 'store']);
    Route::get('transactions/{id}', [TransactionController::class, 'show']);
    Route::delete('transactions/{id}', [TransactionController::class, 'destroy']);
    
});



