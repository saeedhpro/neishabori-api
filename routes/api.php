<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CooperationRequestController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/register/verify', [UserController::class, 'verifyRegister'])->name('register.verify');


Route::prefix('/own')->group(function () {
    Route::get('/', [UserController::class, 'own'])->middleware('auth:api')->name('own');
    Route::get('/addresses', [AddressController::class, 'ownAddresses'])->middleware('auth:api')->name('addresses.ownAddresses');
    Route::get('/orders', [OrderController::class, 'ownOrders'])->middleware('auth:api')->name('orders.ownOrders');
    Route::get('/favourites', [ProductController::class, 'ownFavouriteProducts'])->middleware('auth:api')->name('favourites.ownFavouriteProducts');
    Route::get('/comments', [CommentController::class, 'ownComments'])->middleware('auth:api')->name('comments.ownComments');
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
    Route::get('/{id}/comments', [ArticleController::class, 'destroy'])->middleware('auth:api')->name('articles.destroy');
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
    Route::get('/', [OrderController::class, 'index'])->middleware('auth:api')->name('orders.index');
    Route::get('/{id}', [OrderController::class, 'show'])->middleware('auth:api')->name('orders.show');
});

Route::prefix('/categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/{id}', [CategoryController::class, 'show'])->name('categories.show');
});

Route::prefix('/skills')->group(function () {
    Route::get('/', [SkillController::class, 'index'])->name('skills.index');
    Route::get('/{id}', [SkillController::class, 'show'])->name('skills.show');
});

Route::prefix('/cooperations')->group(function () {
    Route::get('/requests', [CooperationRequestController::class, 'index'])->name('cooperations.requests.index');
    Route::get('/requests/{id}', [CooperationRequestController::class, 'show'])->name('cooperations.requests.show');
    Route::post('/requests', [CooperationRequestController::class, 'store'])->name('cooperations.requests.store');
});

Route::prefix('/services')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/{id}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('/requests', [ServiceRequestController::class, 'index'])->name('services.requests.index');
    Route::get('/requests/{id}', [ServiceRequestController::class, 'show'])->name('services.requests.show');
    Route::post('/requests', [ServiceRequestController::class, 'store'])->name('services.requests.store');
});

