<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CustomerManagementController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderManagementController;
use App\Http\Controllers\Admin\ProductManagementController as AdminProductManagementController;
use App\Http\Controllers\Admin\ReviewModerationController;
use App\Http\Controllers\Admin\UmkmManagementController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\ExploreController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\ProfileController as CustomerProfileController;
use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Store\StoreController;
use App\Http\Controllers\Umkm\AiAssistantController;
use App\Http\Controllers\Umkm\AnalyticsController;
use App\Http\Controllers\Umkm\DashboardController as UmkmDashboardController;
use App\Http\Controllers\Umkm\OrderController as UmkmOrderController;
use App\Http\Controllers\Umkm\ProductController as UmkmProductController;
use App\Http\Controllers\Umkm\ProfileController as UmkmProfileController;
use App\Http\Controllers\Umkm\QrController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/store/{store}', [StoreController::class, 'show'])->name('store.show');
Route::get('/store/{store}/produk/{product}', [StoreController::class, 'product'])->name('store.product');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated - shared (notifications)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});

/*
|--------------------------------------------------------------------------
| Customer routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->prefix('akun')->name('customer.')->group(function () {
    Route::get('/jelajah', [ExploreController::class, 'index'])->name('explore');
    Route::get('/profil', [CustomerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [CustomerProfileController::class, 'update'])->name('profile.update');

    Route::get('/keranjang', [CartController::class, 'index'])->name('cart');
    Route::post('/keranjang/{product}', [CartController::class, 'store'])->name('cart.add');
    Route::post('/keranjang/{product}/ganti-toko', [CartController::class, 'switchStore'])->name('cart.switchStore');
    Route::patch('/keranjang/item/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/item/{item}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/pesanan', [CustomerOrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [CustomerOrderController::class, 'show'])->name('orders.show');
    Route::post('/pesanan/{order}/batalkan', [CustomerOrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/pesanan/{order}/ulasan', [ReviewController::class, 'store'])->name('orders.review');
});

/*
|--------------------------------------------------------------------------
| UMKM routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:umkm'])->prefix('umkm')->name('umkm.')->group(function () {
    // Always reachable so the owner can complete/edit their profile even
    // before admin approval.
    Route::get('/profil', [UmkmProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profil', [UmkmProfileController::class, 'update'])->name('profile.update');

    Route::get('/dashboard', [UmkmDashboardController::class, 'index'])->name('dashboard');

    Route::middleware('umkm.approved')->group(function () {
        Route::resource('produk', UmkmProductController::class)->except(['show'])->parameters(['produk' => 'product'])->names('products');

        Route::get('/pesanan', [UmkmOrderController::class, 'index'])->name('orders.index');
        Route::get('/pesanan/{order}', [UmkmOrderController::class, 'show'])->name('orders.show');
        Route::post('/pesanan/{order}/lanjut', [UmkmOrderController::class, 'advance'])->name('orders.advance');
        Route::post('/pesanan/{order}/batalkan', [UmkmOrderController::class, 'cancel'])->name('orders.cancel');

        Route::get('/qr-code', [QrController::class, 'show'])->name('qr');
        Route::get('/asisten-ai', [AiAssistantController::class, 'index'])->name('ai.index');
        Route::post('/asisten-ai', [AiAssistantController::class, 'generate'])->name('ai.generate');
        Route::get('/analitik', [AnalyticsController::class, 'index'])->name('analytics');
    });
});

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/umkm', [UmkmManagementController::class, 'index'])->name('umkm.index');
    Route::get('/umkm/{umkm}', [UmkmManagementController::class, 'show'])->name('umkm.show');
    Route::post('/umkm/{umkm}/setujui', [UmkmManagementController::class, 'approve'])->name('umkm.approve');
    Route::post('/umkm/{umkm}/tolak', [UmkmManagementController::class, 'reject'])->name('umkm.reject');
    Route::post('/umkm/{umkm}/suspend', [UmkmManagementController::class, 'suspend'])->name('umkm.suspend');
    Route::post('/umkm/{umkm}/aktifkan', [UmkmManagementController::class, 'reactivate'])->name('umkm.reactivate');

    Route::get('/pelanggan', [CustomerManagementController::class, 'index'])->name('customers.index');
    Route::post('/pelanggan/{user}/toggle', [CustomerManagementController::class, 'toggleStatus'])->name('customers.toggle');

    Route::get('/kategori', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/kategori', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('/kategori/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/kategori/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/produk', [AdminProductManagementController::class, 'index'])->name('products.index');
    Route::post('/produk/{product}/toggle', [AdminProductManagementController::class, 'toggleStatus'])->name('products.toggle');

    Route::get('/pesanan', [OrderManagementController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [OrderManagementController::class, 'show'])->name('orders.show');

    Route::get('/ulasan', [ReviewModerationController::class, 'index'])->name('reviews.index');
    Route::post('/ulasan/{review}/toggle', [ReviewModerationController::class, 'toggle'])->name('reviews.toggle');
});
