<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CooperationRequestController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/register/verify', [UserController::class, 'verifyRegister'])->name('register.verify');


Route::prefix('/own')->group(function () {
    Route::get('/', [UserController::class, 'own'])->middleware('auth:api')->name('own');
    Route::get('/cart', [UserController::class, 'ownCart'])->middleware('auth:api')->name('own.ownCart');
    Route::get('/addresses', [AddressController::class, 'ownAddresses'])->middleware('auth:api')->name('addresses.ownAddresses');
    Route::get('/orders', [OrderController::class, 'ownOrders'])->middleware('auth:api')->name('orders.ownOrders');
    Route::get('/favourites', [ProductController::class, 'ownFavouriteProducts'])->middleware('auth:api')->name('favourites.ownFavouriteProducts');
    Route::get('/comments', [CommentController::class, 'ownComments'])->middleware('auth:api')->name('comments.ownComments');
    Route::get('/last/products', [ProductController::class, 'ownLastProducts'])->name('comments.ownLastProducts');
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
    Route::get('/{id}/comments', [CommentController::class, 'comments'])->middleware('auth:api')->name('articles.comments');
});

Route::prefix('/comments')->group(function () {
    Route::get('/', [CommentController::class, 'index'])->name('comments.index');
    Route::post('/', [CommentController::class, 'store'])->middleware('auth:api')->name('comments.store');
    Route::get('/{id}', [CommentController::class, 'show'])->name('comments.show');
    Route::put('/{id}', [CommentController::class, 'update'])->middleware('auth:api')->name('comments.update');
    Route::post('/{id}/like', [CommentController::class, 'like'])->middleware('auth:api')->name('comments.like');
    Route::post('/{id}/dislike', [CommentController::class, 'dislike'])->middleware('auth:api')->name('comments.dislike');
    Route::delete('/{id}', [CommentController::class, 'destroy'])->middleware('auth:api')->name('comments.destroy');
    Route::get('/{id}/children', [CommentController::class, 'children'])->name('comments.children');
});

Route::prefix('/questions')->group(function () {
    Route::get('/', [QuestionController::class, 'index'])->name('questions.index');
    Route::post('/', [QuestionController::class, 'store'])->middleware('auth:api')->name('questions.store');
    Route::get('/{id}', [QuestionController::class, 'show'])->name('questions.show');
    Route::put('/{id}', [QuestionController::class, 'update'])->middleware('auth:api')->name('questions.update');
    Route::delete('/{id}', [QuestionController::class, 'destroy'])->middleware('auth:api')->name('questions.destroy');
    Route::get('/{id}/children', [QuestionController::class, 'children'])->name('questions.children');
});

Route::prefix('/addresses')->group(function () {
    Route::post('/', [AddressController::class, 'store'])->middleware('auth:api')->name('addresses.store');
    Route::get('/{id}', [AddressController::class, 'show'])->middleware('auth:api')->name('addresses.show');
    Route::put('/{id}', [AddressController::class, 'update'])->middleware('auth:api')->name('addresses.update');
    Route::delete('/{id}', [AddressController::class, 'destroy'])->middleware('auth:api')->name('addresses.destroy');
});

Route::prefix('/products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/specials/newest', [ProductController::class, 'newestSpecials'])->name('products.newestSpecials');
    Route::post('/', [ProductController::class, 'store'])->middleware('auth:api')->name('products.store');
    Route::get('/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::put('/{id}', [ProductController::class, 'update'])->middleware('auth:api')->name('products.update');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->middleware('auth:api')->name('products.destroy');
    Route::get('/{id}/related', [ProductController::class, 'relatedProducts'])->middleware('auth:api')->name('products.related');
    Route::post('/{id}/favourite', [ProductController::class, 'toggleFavourite'])->middleware('auth:api')->name('products.toggleFavourite');
    Route::get('/{id}/comments', [CommentController::class, 'comments'])->middleware('auth:api')->name('products.comments');
    Route::get('/{id}/questions', [QuestionController::class, 'questions'])->middleware('auth:api')->name('products.questions');
});

Route::prefix('/users')->middleware('auth:api')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
    Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
    Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/{id}/orders', [OrderController::class, 'userOrders'])->name('users.userOrders');
});

Route::prefix('/coupons')->group(function () {
    Route::get('/', [CouponController::class, 'index'])->name('coupons.index');
    Route::post('/', [CouponController::class, 'store'])->middleware('auth:api')->name('coupons.store');
    Route::get('/{code}', [CouponController::class, 'show'])->name('coupons.show');
    Route::put('/{id}', [CouponController::class, 'update'])->middleware('auth:api')->name('coupons.update');
    Route::delete('/{id}', [CouponController::class, 'destroy'])->middleware('auth:api')->name('coupons.destroy');
});

Route::prefix('/carts')->group(function () {
    Route::post('/add', [CartController::class, 'addCartItem'])->middleware('auth:api')->name('carts.addCartItem');
    Route::post('/remove', [CartController::class, 'removeCartItem'])->middleware('auth:api')->name('carts.removeCartItem');
});

Route::prefix('/orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->middleware('auth:api')->name('orders.index');
    Route::get('/{id}', [OrderController::class, 'show'])->middleware('auth:api')->name('orders.show');
});

Route::prefix('/categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/all', [CategoryController::class, 'all'])->name('categories.index');
    Route::post('/', [CategoryController::class, 'store'])->middleware('auth:api')->name('categories.store');
    Route::get('/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::put('/{id}', [CategoryController::class, 'update'])->middleware('auth:api')->name('categories.update');
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->middleware('auth:api')->name('categories.destroy');
});

Route::prefix('/skills')->group(function () {
    Route::get('/', [SkillController::class, 'index'])->name('skills.index');
    Route::post('/', [SkillController::class, 'store'])->middleware('auth:api')->name('skills.store');
    Route::get('/{id}', [SkillController::class, 'show'])->name('skills.show');
    Route::put('/{id}', [SkillController::class, 'update'])->middleware('auth:api')->name('skills.update');
    Route::delete('/{id}', [SkillController::class, 'destroy'])->middleware('auth:api')->name('skills.destroy');
});

Route::prefix('/cooperations')->group(function () {
    Route::get('/requests', [CooperationRequestController::class, 'index'])->name('cooperations.requests.index');
    Route::get('/requests/{id}', [CooperationRequestController::class, 'show'])->name('cooperations.requests.show');
    Route::delete('/requests/{id}', [CooperationRequestController::class, 'destroy'])->middleware('auth:api')->name('cooperations.requests.destroy');
    Route::post('/requests', [CooperationRequestController::class, 'store'])->name('cooperations.requests.store');
});

Route::prefix('/services')->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('services.index');
    Route::post('/', [ServiceController::class, 'store'])->middleware('auth:api')->name('services.store');
    Route::put('/{id}', [ServiceController::class, 'update'])->middleware('auth:api')->name('services.update');
    Route::delete('/{id}', [ServiceController::class, 'destroy'])->middleware('auth:api')->name('services.destroy');
    Route::get('/requests', [ServiceRequestController::class, 'index'])->name('services.requests.index');
    Route::get('/requests/{id}', [ServiceRequestController::class, 'show'])->name('services.requests.show');
    Route::delete('/requests/{id}', [ServiceRequestController::class, 'destroy'])->middleware('auth:api')->name('services.requests.destroy');
    Route::post('/requests', [ServiceRequestController::class, 'store'])->name('services.requests.store');
    Route::get('/{id}', [ServiceController::class, 'show'])->name('services.show');
});

Route::prefix('/brands')->group(function () {
    Route::get('/', [BrandController::class, 'index'])->name('brands.index');
    Route::post('/', [BrandController::class, 'store'])->middleware('auth:api')->name('brands.store');
    Route::get('/{id}', [BrandController::class, 'show'])->name('brands.show');
    Route::put('/{id}', [BrandController::class, 'update'])->middleware('auth:api')->name('brands.update');
    Route::delete('/{id}', [BrandController::class, 'destroy'])->middleware('auth:api')->name('brands.destroy');
});

Route::prefix('/customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::post('/', [CustomerController::class, 'store'])->middleware('auth:api')->name('customers.store');
    Route::get('/{id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::put('/{id}', [CustomerController::class, 'update'])->middleware('auth:api')->name('customers.update');
    Route::delete('/{id}', [CustomerController::class, 'destroy'])->middleware('auth:api')->name('customers.destroy');
});

Route::prefix('/orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::post('/{id}/action', [OrderController::class, 'action'])->name('orders.action');
});

Route::prefix('/consultations')->group(function () {
    Route::get('/', [ConsultationController::class, 'index'])->name('consultations.index');
    Route::post('/', [ConsultationController::class, 'store'])->name('consultations.store');
    Route::get('/{id}', [ConsultationController::class, 'show'])->name('consultations.show');
    Route::delete('/{id}', [ConsultationController::class, 'destroy'])->middleware('auth:api')->name('consultations.destroy');
});

Route::prefix('/faqs')->group(function () {
    Route::get('/', [FaqController::class, 'index'])->name('faq.index');
    Route::get('/type', [FaqController::class, 'byType'])->name('faq.byType');
    Route::post('/', [FaqController::class, 'store'])->middleware('auth:api')->name('faq.store');
    Route::get('/{id}', [FaqController::class, 'show'])->name('faq.show');
    Route::put('/{id}', [FaqController::class, 'update'])->middleware('auth:api')->name('faq.update');
    Route::delete('/{id}', [FaqController::class, 'destroy'])->middleware('auth:api')->name('faq.destroy');
});

Route::prefix('/attributes')->group(function () {
    Route::get('/', [AttributeController::class, 'index'])->name('attributes.index');
    Route::post('/', [AttributeController::class, 'store'])->middleware('auth:api')->name('attributes.store');
    Route::get('/{id}', [AttributeController::class, 'show'])->name('attributes.show');
    Route::put('/{id}', [AttributeController::class, 'update'])->middleware('auth:api')->name('attributes.update');
    Route::delete('/{id}', [AttributeController::class, 'destroy'])->middleware('auth:api')->name('attributes.destroy');
});

Route::prefix('/contacts')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->middleware('auth:api')->name('contacts.index');
    Route::post('/', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('/{id}', [ContactController::class, 'show'])->name('contacts.show');
    Route::put('/{id}', [ContactController::class, 'update'])->middleware('auth:api')->name('contacts.update');
    Route::delete('/{id}', [ContactController::class, 'destroy'])->middleware('auth:api')->name('contacts.destroy');
});

Route::post('/upload', [UploadController::class, 'upload'])->middleware('auth:api')->name('upload.upload');
Route::get('/search/values', [AdminController::class, 'searchValues'])->name('search.searchValues');
