<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\TransactionController;
use App\Http\Controllers\api\ServiceController;
use App\Http\Controllers\api\SaleController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {


});

Route::apiResources([
    'products' => ProductController::class,
    'customers' => CustomerController::class,
    'orders' => OrderController::class,
    'transactions' => TransactionController::class,
    'services' => ServiceController::class,
    'sales' => SaleController::class,
]);

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

