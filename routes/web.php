<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WarrantyController;
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;


// Trang chủ
Route::get('/', [HomeController::class, 'index']);


// Danh sách và chi tiết sản phẩm
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);


// ================= ĐĂNG NHẬP =================

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.submit');


// ================= GOOGLE LOGIN =================

Route::get('/auth/google', [GoogleController::class, 'redirect'])
    ->name('google.login');

Route::get('/auth/google/callback', [GoogleController::class, 'callback']);


// ================= ĐĂNG KÝ =================

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('throttle:5,1')
    ->name('register.submit');


// ================= QUÊN MẬT KHẨU =================

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');


Route::post('/forgot-password', [AuthController::class, 'sendOtp'])
    ->name('password.sendOtp');

Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])
    ->name('password.update');

// ================= NHẬP OTP =================

Route::get('/verify-otp', function () {
    return view('auth.verify-otp');
})->name('password.verifyOtp');


Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])
    ->name('password.verifyOtp.submit');

Route::get('/resend-otp', [AuthController::class, 'resendOtp'])
    ->name('password.resendOtp');
// ================= ĐĂNG XUẤT =================

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


// ================= WARRANTY =================

Route::prefix('warranty')
    ->name('warranty.')
    ->controller(WarrantyController::class)
    ->group(function () {

        Route::get('/', 'index')
            ->name('index');

        Route::get('/create-request', 'create')
            ->name('create');

        Route::get('/status', 'status')
            ->name('status');

        Route::get('/history', 'history')
            ->name('history');

    });


// ================= CÁC CHỨC NĂNG CẦN ĐĂNG NHẬP =================

Route::middleware('auth')->group(function () {


    // Customer
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


    // Tài khoản
    Route::get('/account/profile', [AccountController::class, 'profile']);


    // Thông báo
    Route::get('/notifications', [NotificationController::class, 'index']);


    // Đăng xuất
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});


// Danh mục
Route::get('/categories', [CategoryController::class, 'index']);