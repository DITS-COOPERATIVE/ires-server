<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\api\BarcodeController;
use App\Http\Controllers\api\SaleController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\ServiceController;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\api\TransactionController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware(['auth:sanctum'])->group(function () {

Route::apiResources([
    'products' => ProductController::class,
    'customers' => CustomerController::class,
    'orders' => OrderController::class,
    'services' => ServiceController::class,
    'reservations' => ReservationController::class,
    'reports' => ReportController::class
]);

Route::get('reports/{report}/data', [ReportController::class, 'getData']);
Route::post('services/{service}/availability', [ServiceController::class, 'availability']);
Route::post('auth/logout', [AuthController::class, 'logoutUser']);

// });

Route::post('auth/register', [AuthController::class, 'createUser']);
Route::post('auth/login', [AuthController::class, 'loginUser']);
Route::post('generate-barcode', [BarcodeController::class, 'generate']);
