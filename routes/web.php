<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
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

Route::get('user/create',[UserController::class,'create']);
Route::post('user/store', [UserController::class, 'store'])->name('user.store');

// Route::resource('products', OrderController::class);

Route::get('order/create',[OrderController::class,'create'])->name('order.create');
Route::post('order/store', [OrderController::class, 'store'])->name('order.store');
Route::get('order/index', [OrderController::class, 'index'])->name('order.index');
Route::get('order/{id}/destroy', [OrderController::class, 'destroy'])->name('order.destroy');
Route::get('order/{id}/edit', [OrderController::class, 'edit'])->name('order.edit');
Route::post('order/{id}/update', [OrderController::class, 'update'])->name('order.update');

Route::get('item/create',[ItemController::class,'create']);
Route::post('item/store', [ItemController::class, 'store'])->name('item.store');
Route::get('item/index', [ItemController::class, 'index'])->name('item.index');
Route::get('item/{id}/destroy', [ItemController::class, 'destroy'])->name('item.destroy');
Route::get('item/{id}/edit', [ItemController::class, 'edit'])->name('item.edit');
Route::post('item/{id}/update', [ItemController::class, 'update'])->name('item.update');