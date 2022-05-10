<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/register/verify', [UserController::class, 'verifyRegister'])->name('register.verify');


Route::prefix('/own')->group(function () {
    Route::get('/', [UserController::class, 'own'])->middleware('auth:api')->name('own');
    Route::get('/addresses', [AddressController::class, 'ownAddresses'])->middleware('auth:api')->name('addresses.ownAddresses');
    Route::get('/orders', [OrderController::class, 'ownOrders'])->middleware('auth:api')->name('orders.ownOrders');
});

Route::prefix('/provinces')->group(function () {
    Route::get('/', [ProvinceController::class, 'index'])->name('provinces.index');
});

Route::prefix('/articles')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
    Route::post('/', [ArticleController::class, 'store'])->middleware('auth:api')->name('articles.store');
    Route::get('/{id}', [ArticleController::class, 'show'])->name('articles.show');
    Route::put('/{id}', [ArticleController::class, 'update'])->middleware('auth:api')->name('articles.update');
    Route::delete('/{id}', [ArticleController::class, 'destroy'])->middleware('auth:api')->name('articles.destroy');
});

Route::prefix('/addresses')->group(function () {
    Route::post('/', [AddressController::class, 'store'])->middleware('auth:api')->name('addresses.store');
    Route::get('/{id}', [AddressController::class, 'show'])->middleware('auth:api')->name('addresses.show');
    Route::put('/{id}', [AddressController::class, 'update'])->middleware('auth:api')->name('addresses.update');
    Route::delete('/{id}', [AddressController::class, 'destroy'])->middleware('auth:api')->name('addresses.destroy');
});

Route::prefix('/products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->middleware('auth:api')->name('products.index');
    Route::get('/{id}', [ProductController::class, 'show'])->middleware('auth:api')->name('products.show');
    Route::post('/{id}/favourite', [ProductController::class, 'toggleFavourite'])->middleware('auth:api')->name('products.toggleFavourite');
});


Route::prefix('/orders')->group(function () {
    Route::post('/{id}/favourite', [ProductController::class, 'toggleFavourite'])->middleware('auth:api')->name('products.toggleFavourite');
});

