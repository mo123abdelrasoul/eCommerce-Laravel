<?php

use App\Http\Controllers\Admin\LoginAdminController;
use App\Http\Controllers\Admin\VendorController as AdminVendorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
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
use App\Http\Controllers\Vendor\vendorDashboard;
use App\Http\Controllers\VendorController;
use App\Models\Order;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

Route::get('/{language}/change-language', [LanguageController::class, 'changeLanguage'])->name('change.language');
Route::group(['prefix' => '{lang?}', 'middleware' => 'setLocale'], function () {
    /* ------------------------------- Start Public ---------------------------------------- */
    // Register
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'registerForm'])->name('registerForm');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    /* ------------------------------- End Public ---------------------------------------- */


    /* ------------------------------- Start User ---------------------------------------- */
    // Home
    Route::get('/', [HomeController::class, 'index'])->name('home')->middleware(['checkUserRole:user']);

    // Login For User
    Route::get('/login', [AuthController::class, 'ShowUserLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'UserLoginForm'])->name('UserLoginForm');

    // About
    Route::get('/about', function () {
        return view('user.about');
    })->name('about');
    /* ------------------------------- End User ---------------------------------------- */


    /* ------------------------------- Start Vendor ---------------------------------------- */

    // Show Vendor Login Page
    Route::get('/VendorLogin', [LoginVendorController::class, 'index'])->name('vendor.login');

    // Vendor Login Submission
    Route::post('/LoginDashboard', [LoginVendorController::class, 'VendorLoginForm'])->name('vendor.login.submit');
    Route::delete('/LogoutDashboard', [LoginVendorController::class, 'VendorLogoutForm'])->name('vendor.logout.submit');

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

    /* ------------------------------- Start Admin ---------------------------------------- */
    // Show Admin Dashboard Page
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard')->middleware(['checkUserRole:admin']);

    // Vendors Management
    Route::resource('admin/vendors', AdminVendorController::class)->except(['create', 'store']);
    Route::get('/admin/pendingVendors', [AdminVendorController::class, 'pending'])->name('vendors.pending');
    Route::put('/admin/pendingVendors{vendor}', [AdminVendorController::class, 'updateStatus'])->name('vendors.update.status');

    // Show Admin Login Page
    Route::get('/AdminLoginDashboard', [LoginAdminController::class, 'ShowAdminLoginForm'])->name('admin.login');

    // Admin Login Submission
    Route::post('/AdminLoginDashboard', [LoginAdminController::class, 'AdminLoginForm'])->name('admin.login.submit');
    /* ------------------------------- End Vendor ---------------------------------------- */
});
