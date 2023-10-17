<?php

use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\SalesController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\Api\UsersInfoController;
use App\Http\Controllers\api\TransactionController;
use App\Http\Controllers\api\VerificationController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResources([
        'products' => ProductController::class,
        'customers' => CustomerController::class,
        'orders' => OrderController::class,
        'transactions' => TransactionController::class,
        'sales' => SalesController::class,
    ]);
});
