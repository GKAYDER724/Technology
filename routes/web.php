<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AuthController;

//  Trang chủ
Route::get('/', [HomeController::class, 'index']);

//  Danh sách và chi tiết sản phẩm
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

//  Đăng nhập
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.submit');

//  Đăng ký
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('throttle:5,1')
    ->name('register.submit');

//  Các chức năng yêu cầu đăng nhập
Route::middleware('auth')->group(function () {

    //  Các chức năng dành cho Customer
    Route::middleware('role:customer')->group(function () {

        // Giỏ hàng và thanh toán
        Route::get('/cart', [CartController::class, 'index']);
        Route::get('/checkout', [CartController::class, 'checkout']);

        // Đơn hàng
        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{id}', [OrderController::class, 'show']);
        Route::get('/orders/{id}/cancel', [OrderController::class, 'cancel']);

        // Đánh giá
        Route::get('/reviews', [ReviewController::class, 'index']);
    });

    //  Tài khoản
    Route::get('/account/profile', [AccountController::class, 'profile']);

    //  Thông báo
    Route::get('/notifications', [NotificationController::class, 'index']);

    //  Đăng xuất
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});