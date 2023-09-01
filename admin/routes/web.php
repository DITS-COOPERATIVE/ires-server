<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\DashboardController;
use App\Http\Controllers\api\TransactionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get(
    '/dashboard',
    [DashboardController::class, 'show'],
)->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resources([
        'products'              => ProductController::class,
        'customers'             => CustomerController::class,
        'orders'                => OrderController::class,
        'transactions'          => TransactionController::class,
        'orders.transactions'   => TransactionController::class,
    ]);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
