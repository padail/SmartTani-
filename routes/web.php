<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Buyer\BuyerDashboardController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\Monitoring\MonitoringDashboardController;
use App\Http\Controllers\Owner\OwnerDashboardController;
use App\Http\Controllers\Public\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DeviceController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:admin,owner'])
    ->prefix('monitoring')
    ->name('monitoring.')
    ->group(function () {
        Route::get('/', [MonitoringDashboardController::class, 'index'])->name('dashboard');
        Route::get('/latest', [MonitoringDashboardController::class, 'latest'])->name('latest');
    });
Route::middleware('auth')
    ->get('/dashboard', DashboardRedirectController::class)
    ->name('dashboard');

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');
        Route::resource('devices', DeviceController::class);

        Route::patch('/devices/{device}/rotate-key', [DeviceController::class, 'rotateKey'])
            ->name('devices.rotate-key');

        Route::patch('/devices/{device}/toggle-status', [DeviceController::class, 'toggleStatus'])
            ->name('devices.toggle-status');
    });

Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])
            ->name('dashboard');
    });

Route::middleware(['auth', 'role:buyer'])
    ->prefix('buyer')
    ->name('buyer.')
    ->group(function () {
        Route::get('/dashboard', [BuyerDashboardController::class, 'index'])
            ->name('dashboard');
    });


// // Public Routes
// Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/profil-kelompok-tani', [PublicPageController::class, 'profile'])->name('public.profile');
// Route::get('/proses-budidaya-melon', [PublicPageController::class, 'cultivation'])->name('public.cultivation');
// Route::get('/produk', [PublicProductController::class, 'index'])->name('products.index');
// Route::get('/produk/{product:slug}', [PublicProductController::class, 'show'])->name('products.show');
// Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');
// Route::get('/kontak', [ContactController::class, 'index'])->name('contact.index');
// Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');

// // Buyer Routes
// Route::middleware(['auth', 'role:buyer'])->prefix('buyer')->name('buyer.')->group(function () {
//     Route::get('/dashboard', [BuyerDashboardController::class, 'index'])->name('dashboard');

//     Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
//     Route::post('/cart/items', [CartController::class, 'store'])->name('cart.items.store');
//     Route::delete('/cart/items/{cartItem}', [CartController::class, 'destroy'])->name('cart.items.destroy');

//     Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
//     Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

//     Route::get('/orders', [BuyerOrderController::class, 'index'])->name('orders.index');
//     Route::get('/orders/{order}', [BuyerOrderController::class, 'show'])->name('orders.show');

//     Route::post('/payments/{order}', [BuyerPaymentController::class, 'uploadProof'])->name('payments.upload');
//     Route::post('/reviews/{order}', [ReviewController::class, 'store'])->name('reviews.store');
// });

// // Admin Routes
// Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

//     Route::resource('/users', AdminUserController::class);
//     Route::resource('/products', AdminProductController::class);
//     Route::resource('/orders', AdminOrderController::class);
//     Route::resource('/payments', AdminPaymentController::class);
//     Route::resource('/devices', AdminDeviceController::class);
//     Route::resource('/contents', AdminContentController::class);
//     Route::resource('/galleries', AdminGalleryController::class);

//     Route::get('/monitoring/soil', [AdminSoilMonitoringController::class, 'index'])->name('monitoring.soil');
//     Route::get('/monitoring/water', [AdminWaterMonitoringController::class, 'index'])->name('monitoring.water');

//     Route::get('/reports/sales', [AdminReportController::class, 'sales'])->name('reports.sales');
//     Route::get('/reports/monitoring', [AdminReportController::class, 'monitoring'])->name('reports.monitoring');
// });
// // Owner Routes
// Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
//     Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');

//     Route::resource('/products', OwnerProductController::class);
//     Route::get('/orders', [OwnerOrderController::class, 'index'])->name('orders.index');
//     Route::get('/orders/{order}', [OwnerOrderController::class, 'show'])->name('orders.show');

//     Route::get('/payments', [OwnerPaymentController::class, 'index'])->name('payments.index');
//     Route::get('/reports', [OwnerReportController::class, 'index'])->name('reports.index');
// });
