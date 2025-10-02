<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginAdminController;
use App\Http\Controllers\admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VendorController as AdminVendorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\ShippingController as CustomerShippingController;
use App\Http\Controllers\Customer\UserController as CustomerUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Vendor\BrandController;
use App\Http\Controllers\Vendor\CategoryController as VendorCategoryController;
use App\Http\Controllers\Vendor\CouponController;
use App\Http\Controllers\Vendor\DashboardController;
use App\Http\Controllers\Vendor\ProductsController;
use App\Http\Controllers\Vendor\LoginVendorController;
use App\Http\Controllers\Vendor\OrderController;
use App\Http\Controllers\Vendor\ProductController as VendorProductController;
use App\Http\Controllers\Vendor\ProfileController;
use App\Http\Controllers\Vendor\VendorController as VendorVendorController;
use App\Http\Controllers\Vendor\vendorDashboard;
use App\Http\Controllers\VendorController;
use App\Models\Order;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

Route::get('/{language}/change-language', [LanguageController::class, 'changeLanguage'])->name('change.language');
Route::group(['prefix' => '{lang?}', 'middleware' => 'setLocale'], function () {

    /* -------------------------------------------- Start Admin ------------------------------------------------------------------------ */
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard')->middleware(['checkUserRole:admin']);

    // Vendors Management
    Route::get('admin/vendors/pending', [AdminVendorController::class, 'pending'])->name('vendors.pending');
    Route::put('admin/vendors/pending/{vendor}', [AdminVendorController::class, 'updateStatus'])->name('vendors.update.status');
    Route::resource('admin/vendors', AdminVendorController::class)->except(['create', 'store']);

    // Users Management
    Route::resource('admin/users', UserController::class)->except(['create', 'store']);
    Route::put('admin/users/restore/{user}', [UserController::class, 'restore'])->name('users.restore');

    // Products Management
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('products', AdminProductController::class)->except(['create', 'store']);
        Route::put('products/restore/{product}', [AdminProductController::class, 'restore'])->name('products.restore');
    });

    // Shipping Management
    Route::resource('admin/shipping', ShippingController::class);

    // Show Admin Login Page
    Route::get('/admin/login', [AdminController::class, 'index'])->name('admin.login');

    // Admin Login Submission
    Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');

    // Admin Logout Submission
    Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout.submit');
    /* -------------------------------------------- End Admin ------------------------------------------------------------------------- */

    /* -------------------------------------------- Start Public ------------------------------------------------------------------------- */
    // Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'registerForm'])->name('registerForm');
    /* -------------------------------------------- End Public ------------------------------------------------------------------------- */

    /* -------------------------------------------- Start User ------------------------------------------------------------------------- */
    // Home
    Route::get('/', [CustomerUserController::class, 'index'])->name('home')->middleware(['checkUserRole:user']);

    // Login For User
    Route::get('/login', [CustomerUserController::class, 'index'])->name('user.login');
    Route::post('/login', [CustomerUserController::class, 'login'])->name('user.login.submit');

    // Logout For User
    Route::post('/logout', [CustomerUserController::class, 'logout'])->name('user.logout.submit');

    // Add to Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');

    Route::post('/checkout/shipping-rate', [CustomerShippingController::class, 'getShippingRate'])->name('checkout.shipping.rate');
    Route::get('/checkout', [CheckoutController::class, 'showCheckoutForm'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');


    // About
    Route::get('/about', function () {
        return view('user.about');
    })->name('about');
    /* -------------------------------------------- End User ------------------------------------------------------------------------- */

    /* -------------------------------------------- Start Vendor ------------------------------------------------------------------------- */
    // Show Vendor Login Page
    Route::get('/VendorLogin', [VendorVendorController::class, 'index'])->name('vendor.login');

    // Vendor Login Submission
    Route::post('/vendor/login', [VendorVendorController::class, 'login'])->name('vendor.login.submit');
    Route::delete('/vendor/logout', [VendorVendorController::class, 'logout'])->name('vendor.logout.submit');

    Route::group(['middleware' => 'checkUserRole:vendor'], function () {
        // Show Vendor Dashboard Page
        Route::get('/VendorDashboard', [DashboardController::class, 'index'])->name('vendor.dashboard');

        // Profile
        Route::get('/VendorProfile', [ProfileController::class, 'index'])->name('vendor.profile.index');
        Route::get('/VendorProfile/{profile}/edit', [ProfileController::class, 'edit'])->name('vendor.profile.edit');
        Route::put('/VendorProfile/{profile}', [ProfileController::class, 'update'])->name('vendor.profile.update');

        // Categories
        Route::resource('categories', VendorCategoryController::class);

        // Products
        Route::resource('products', VendorProductController::class);

        // Brands
        Route::resource('brands', BrandController::class);

        // Coupons
        Route::resource('coupons', CouponController::class);

        // Orders
        Route::resource('orders', OrderController::class)->except(['create', 'store']);
    });
    /* ------------------------------- End Vendor ---------------------------------------- */
});
