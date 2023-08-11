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

Route::get('/dashboard',
[DashboardController::class,'show'],
)->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/products',[ProductController::class,'index'])->name('products.index');
    Route::get('/customers',[CustomerController::class,'index'])->name('customers.index');
    Route::get('/orders',[OrderController::class,'index'])->name('orders.index');
    Route::get('/add-order',[OrderController::class,'create'])->name('add-order');
    Route::post('/add-order',[OrderController::class,'store'],function () {
        return redirect('/orders');
    });
    Route::get('/transactions',[TransactionController::class,'index'])->name('transactions.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
