<?php

use App\Http\Controllers\ArticleController;
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
