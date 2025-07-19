<?php

use App\Http\Controllers\Admin\LoginAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProductController;
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
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
    // Show Vendor Dashboard Page
    Route::get('/Dashboard', [DashboardController::class, 'vendorDashboard'])
        ->name('vendor.dashboard')
        ->middleware(['checkUserRole:vendor']);

    // Show Vendor Login Page
    Route::get('/LoginDashboard', [LoginVendorController::class, 'ShowVendorLoginForm'])->name('vendor.login');

    // Vendor Login Submission
    Route::post('/LoginDashboard', [LoginVendorController::class, 'VendorLoginForm'])->name('vendor.login.submit');

    Route::group(['middleware' => 'checkUserRole:vendor'], function () {

        // Profile
        Route::get('/DashboardProfile', [ProfileController::class, 'index'])->name('dashboard.profile');
        Route::get('/DashboardProfile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/DashboardProfile/update', [ProfileController::class, 'update'])->name('profile.update');

        // Products
        Route::get('/DashboardProducts', [VendorProductController::class, 'DashboardProductsPage'])->name('DashboardProductsPage');
        Route::get('/DashboardProducts/create', [VendorProductController::class, 'create'])->name('product.create');
        Route::post('/DashboardProducts/store', [VendorProductController::class, 'store'])->name('product.store');
        Route::get('/product/{id}', [VendorProductController::class, 'show'])->name('product.show');
        Route::get('/product/{id}/edit', [VendorProductController::class, 'edit'])->name('product.edit');
        Route::put('/product/{id}/update', [VendorProductController::class, 'update'])->name('product.update');
        Route::delete('product/{id}/destroy', [VendorProductController::class, 'destroy'])->name('product.destroy');

        // Orders
        Route::get('/orders', [OrderController::class, 'DashboardOrdersPage'])->name('DashboardOrdersPage');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('order.show');
        Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('order.edit');
        Route::put('/orders/{id}/update', [OrderController::class, 'update'])->name('order.update');
        Route::delete('/orders/{id}/destroy', [OrderController::class, 'destroy'])->name('order.destroy');
    });

    /* ------------------------------- End Vendor ---------------------------------------- */

    /* ------------------------------- Start Admin ---------------------------------------- */
    // Show Admin Dashboard Page
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard')->middleware(['checkUserRole:admin']);


    // Show Admin Login Page
    Route::get('/AdminLoginDashboard', [LoginAdminController::class, 'ShowAdminLoginForm'])->name('admin.login');

    // Admin Login Submission
    Route::post('/AdminLoginDashboard', [LoginAdminController::class, 'AdminLoginForm'])->name('admin.login.submit');
    /* ------------------------------- End Vendor ---------------------------------------- */
});


// // Home
// Route::get('/', [AuthController::class, 'ShowUserLoginForm'])->name('home')->middleware(['checkUserRole:user']);


// // Login For User
// // Route::get('/login', [AuthController::class, 'ShowUserLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'UserLoginForm'])->name('UserLoginForm');

// // Register
// Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
// Route::post('/register', [AuthController::class, 'registerForm'])->name('registerForm');

// // Logout
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// // Contact
// Route::get('/contact')->name('contact')->middleware(['checkUserRole:user']);


// /* Vendor */

// // Show Vendor Dashboard Page
// Route::get('/Dashboard', function () {
//     return view('vendor.dashboard');
// })->name('vendor.dashboard')->middleware(['checkUserRole:vendor']);


// // Show Vendor Login Page
// Route::get('/LoginDashboard', [LoginVendorController::class, 'ShowVendorLoginForm'])->name('vendor.login');

// // Show Vendor Login Submission
// Route::post('/LoginDashboard', [LoginVendorController::class, 'VendorLoginForm'])->name('vendor.login.submit');
// Route::get('/DashboardProducts', [ProductsController::class, 'DashboardProductsPage'])->name('DashboardProductsPage');


// /* Admin */

// // Show Admin Dashboard Page
// Route::get('/admin', function () {
//     return view('admin.dashboard');
// })->name('admin.dashboard')->middleware(['checkUserRole:admin']);


// // Show Admin Login Page
// Route::get('/AdminLoginDashboard', [LoginAdminController::class, 'ShowAdminLoginForm'])->name('admin.login');

// // Show Admin Login Submission
// Route::post('/AdminLoginDashboard', [LoginAdminController::class, 'AdminLoginForm'])->name('admin.login.submit');
