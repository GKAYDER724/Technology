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
use App\Http\Controllers\WarrantyController;


// 1. Trang chủ
Route::get('/', [HomeController::class, 'index']);

// 2. Trang danh sách sản phẩm
Route::get('/products', [ProductController::class, 'index']);

// 3. Trang chi tiết sản phẩm
Route::get('/products/{id}', [ProductController::class, 'show']);

// 4. Trang giỏ hàng
Route::get('/cart', [CartController::class, 'index']);

// 5. Trang thanh toán
Route::get('/checkout', [CartController::class, 'checkout']);

// 6. Trang lịch sử và chi tiết đơn hàng
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);

// 7. Trang yêu cầu hủy đơn
Route::get('/orders/{id}/cancel', [OrderController::class, 'cancel']);

// 8. Trang đánh giá sản phẩm
Route::get('/reviews', [ReviewController::class, 'index']);

// 9. Trang tài khoản cá nhân: thông tin cá nhân
Route::get('/account/profile', [AccountController::class, 'profile']);

// 10. Trang thông báo
Route::get('/notifications', [NotificationController::class, 'index']);

// Trang đăng nhập
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.submit');

// Trang đăng ký
Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('throttle:5,1')
    ->name('register.submit');

// Đăng xuất
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
// Warranty Routes
Route::prefix('warranty')
    ->name('warranty.')
    ->controller(WarrantyController::class)
    ->group(function () {

        // Warranty overview
        Route::get('/', 'index')
            ->name('index');

        // Create warranty request
        Route::get('/create-request', 'create')
            ->name('create');

        // Check warranty status
        Route::get('/status', 'status')
            ->name('status');

        // Warranty history
        Route::get('/history', 'history')
            ->name('history');
    });
