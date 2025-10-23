<?php

use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController as AdminForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController as AdminResetPasswordController;
use App\Http\Controllers\Admin\Vendor\VendorController as AdminVendorController;
use App\Http\Controllers\Admin\Product\ProductController as AdminProductController;
use App\Http\Controllers\Admin\Shipping\ShippingController as AdminShippingController;
use App\Http\Controllers\Admin\Customer\UserController as AdminUserController;

use App\Http\Controllers\Vendor\Auth\LoginController as VendorLoginController;
use App\Http\Controllers\Vendor\Auth\ForgotPasswordController as VendorForgotPasswordController;
use App\Http\Controllers\Vendor\Auth\ResetPasswordController as VendorResetPasswordController;
use App\Http\Controllers\Vendor\Profile\ProfileController as VendorProfileController;
use App\Http\Controllers\Vendor\Product\ProductController as VendorProductController;
use App\Http\Controllers\Vendor\Product\CategoryController as VendorCategoryController;
use App\Http\Controllers\Vendor\Product\BrandController as VendorBrandController;
use App\Http\Controllers\Vendor\Coupon\CouponController as VendorCouponController;
use App\Http\Controllers\Vendor\Order\OrderController as VendorOrderController;

use App\Http\Controllers\Customer\Auth\LoginController as CustomerLoginController;
use App\Http\Controllers\Customer\Auth\ForgotPasswordController as CustomerForgotPasswordController;
use App\Http\Controllers\Customer\Auth\ResetPasswordController as CustomerResetPasswordController;
use App\Http\Controllers\Customer\Cart\CartController;
use App\Http\Controllers\Customer\Checkout\CheckoutController;
use App\Http\Controllers\Customer\Shipping\ShippingController as CustomerShippingController;

use App\Http\Controllers\Common\Auth\RegisterController;
use App\Http\Controllers\Common\Auth\Socialite\GoogleController as SocialiteGoogleController;
use App\Http\Controllers\Common\Localization\LanguageController as LocalizationLanguageController;
use App\Http\Controllers\Admin\Payment\PaymentController;
use App\Http\Controllers\Admin\Profile\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\Product\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\Product\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\Product\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\Product\OrderController as AdminOrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Language
|--------------------------------------------------------------------------
*/

Route::get('/{language}/change-language', [LocalizationLanguageController::class, 'changeLanguage'])->name('change.language');

/*
|--------------------------------------------------------------------------
| Public Routes (Register / Login / Socialite / Password Reset)
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => '{lang?}', 'middleware' => 'setLocale'], function () {

    // Registration
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'registerForm'])->name('registerForm');

    // Socialite
    Route::get('auth/google', [SocialiteGoogleController::class, 'redirect'])->name('google.redirect');
    Route::get('auth/google/callback', [SocialiteGoogleController::class, 'callback'])->name('google.callback');

    /*
    |--------------------------------------------------------------------------
    | Customer Login / Password Reset
    |--------------------------------------------------------------------------
    */
    Route::prefix('user')->name('user.')->group(function () {
        // Login
        Route::get('login', [CustomerLoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [CustomerLoginController::class, 'login'])->name('login.submit');

        // Forgot / Reset Password
        Route::get('password/reset', [CustomerForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [CustomerForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [CustomerResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [CustomerResetPasswordController::class, 'reset'])->name('password.update');
    });

    /*
    |--------------------------------------------------------------------------
    | Vendor Login / Password Reset
    |--------------------------------------------------------------------------
    */
    Route::prefix('vendor')->name('vendor.')->group(function () {
        // Login
        Route::get('login', [VendorLoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [VendorLoginController::class, 'login'])->name('login.submit');

        // Forgot / Reset Password
        Route::get('password/reset', [VendorForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [VendorForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [VendorResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [VendorResetPasswordController::class, 'reset'])->name('password.update');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Login / Password Reset
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {
        // Login
        Route::get('login', [AdminLoginController::class, 'index'])->name('login');
        Route::post('login', [AdminLoginController::class, 'login'])->name('login.submit');

        // Forgot / Reset Password
        Route::get('password/reset', [AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [AdminResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [AdminResetPasswordController::class, 'reset'])->name('password.update');
    });

    /*
    |--------------------------------------------------------------------------
    | Customer Protected Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkUserRole:user'])->group(function () {
        Route::get('/', [CustomerLoginController::class, 'index'])->name('home');
        Route::prefix('user')->name('user.')->group(function () {
            Route::post('logout', [CustomerLoginController::class, 'logout'])->name('logout.submit');
            Route::get('dashboard', [CustomerLoginController::class, 'index'])->name('home');

            // Cart & Checkout
            Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
            Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
            Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
            Route::delete('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');

            Route::post('/checkout/shipping-rate', [CustomerShippingController::class, 'getShippingRate'])->name('checkout.shipping.rate');
            Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('apply.coupon');
            Route::get('/checkout', [CheckoutController::class, 'showCheckoutForm'])->name('checkout.index');
            Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
            Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Vendor Protected Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkUserRole:vendor'])->group(function () {
        Route::prefix('vendor')->name('vendor.')->group(function () {
            Route::post('logout', [VendorLoginController::class, 'logout'])->name('logout.submit');
            Route::get('dashboard', [VendorLoginController::class, 'dashboard'])->name('dashboard');

            // Vendor resources
            Route::resource('categories', VendorCategoryController::class);
            Route::resource('products', VendorProductController::class);
            Route::resource('brands', VendorBrandController::class);
            Route::resource('coupons', VendorCouponController::class);
            Route::resource('orders', VendorOrderController::class)->except(['create', 'store']);

            // Profile
            Route::get('profile', [VendorProfileController::class, 'index'])->name('profile.index');
            Route::get('profile/{profile}/edit', [VendorProfileController::class, 'edit'])->name('profile.edit');
            Route::put('profile/{profile}', [VendorProfileController::class, 'update'])->name('profile.update');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Protected Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkUserRole:admin'])->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::post('logout', [AdminLoginController::class, 'logout'])->name('logout.submit');
            Route::get('dashboard', function () {
                return view('admin.dashboard');
            })->name('dashboard');

            // Vendors
            Route::get('vendors/pending', [AdminVendorController::class, 'pending'])->name('vendors.pending');
            Route::put('vendors/pending/{vendor}', [AdminVendorController::class, 'updateStatus'])->name('vendors.update.status');
            Route::resource('vendors', AdminVendorController::class)->except(['create', 'store']);

            // Users
            Route::resource('users', AdminUserController::class)->except(['create', 'store']);
            Route::put('users/restore/{user}', [AdminUserController::class, 'restore'])->name('users.restore');

            // Admin Resources
            Route::resource('brands', AdminBrandController::class);
            Route::resource('categories', AdminCategoryController::class);
            Route::resource('coupons', AdminCouponController::class);
            Route::resource('orders', AdminOrderController::class)->except(['create', 'store']);
            Route::resource('products', AdminProductController::class)->except(['create', 'store']);

            // Profile
            Route::resource('profile', AdminProfileController::class)->except(['create', 'store', 'show']);

            // Products
            Route::put('products/restore/{product}', [AdminProductController::class, 'restore'])->name('products.restore');

            // Shipping
            Route::resource('shipping', AdminShippingController::class);
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Payment Callback
    |--------------------------------------------------------------------------
    */
    Route::match(['GET', 'POST'], '/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
    Route::post('/payment/process', [PaymentController::class, 'paymentProcess'])->name('payment.process');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/failed', [PaymentController::class, 'failed'])->name('payment.failed');
});
