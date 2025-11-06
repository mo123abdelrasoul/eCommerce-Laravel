<?php

use App\Http\Controllers\Admin\Access\PermissionController as AdminPermissionController;
use App\Http\Controllers\Admin\Access\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

// Common Controllers
use App\Http\Controllers\Common\Auth\RegisterController;
use App\Http\Controllers\Common\Auth\Socialite\GoogleController as SocialiteGoogleController;
use App\Http\Controllers\Common\Localization\LanguageController as LocalizationLanguageController;

// Admin Controllers
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController as AdminForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController as AdminResetPasswordController;
use App\Http\Controllers\Admin\Vendor\VendorController as AdminVendorController;
use App\Http\Controllers\Admin\Product\ProductController as AdminProductController;
use App\Http\Controllers\Admin\Customer\UserController as AdminUserController;
use App\Http\Controllers\Admin\Finance\FinanceController as AdminFinanceController;
use App\Http\Controllers\Admin\Finance\Withdraw\WithdrawController as AdminWithdrawController;
use App\Http\Controllers\Admin\Profile\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\Product\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\Product\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\Product\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\Product\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\Payment\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\Shipping\ShippingCityController as AdminShippingCityController;
use App\Http\Controllers\Admin\Shipping\ShippingMethodController as AdminShippingMethodController;
use App\Http\Controllers\Admin\Shipping\ShippingRegionController as AdminShippingRegionController;
use App\Http\Controllers\Admin\Chat\ChatController as AdminChatController;
use App\Http\Controllers\Admin\Email\EmailController as AdminEmailController;

// Vendor Controllers
use App\Http\Controllers\Vendor\Auth\LoginController as VendorLoginController;
use App\Http\Controllers\Vendor\Auth\ForgotPasswordController as VendorForgotPasswordController;
use App\Http\Controllers\Vendor\Auth\ResetPasswordController as VendorResetPasswordController;
use App\Http\Controllers\Vendor\Profile\ProfileController as VendorProfileController;
use App\Http\Controllers\Vendor\Product\ProductController as VendorProductController;
use App\Http\Controllers\Vendor\Product\CategoryController as VendorCategoryController;
use App\Http\Controllers\Vendor\Product\BrandController as VendorBrandController;
use App\Http\Controllers\Vendor\Coupon\CouponController as VendorCouponController;
use App\Http\Controllers\Vendor\Order\OrderController as VendorOrderController;
use App\Http\Controllers\Vendor\Shipping\ShippingMethodController as VendorShippingMethodController;
use App\Http\Controllers\Vendor\Shipping\ShippingRateController as VendorShippingRateController;
use App\Http\Controllers\Vendor\Wallet\WalletController as VendorWalletController;
use App\Http\Controllers\Vendor\Wallet\Withdraw\WithdrawController as VendorWithdrawController;

// Customer Controllers
use App\Http\Controllers\Customer\Auth\LoginController as CustomerLoginController;
use App\Http\Controllers\Customer\Auth\ForgotPasswordController as CustomerForgotPasswordController;
use App\Http\Controllers\Customer\Auth\ResetPasswordController as CustomerResetPasswordController;
use App\Http\Controllers\Customer\Cart\CartController as CustomerCartController;
use App\Http\Controllers\Customer\Checkout\CheckoutController as CustomerCheckoutController;
use App\Http\Controllers\Customer\Shipping\ShippingController as CustomerShippingController;


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

Route::group(['prefix' => '{lang}', 'middleware' => 'setLocale'], function () {

    // Registration
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])
        ->name('register');
    Route::post('/register', [RegisterController::class, 'registerForm'])
        ->name('registerForm');

    // Socialite
    Route::get('auth/google', [SocialiteGoogleController::class, 'redirect'])
        ->name('google.redirect');
    Route::get('auth/google/callback', [SocialiteGoogleController::class, 'callback'])
        ->name('google.callback');

    /*
    |--------------------------------------------------------------------------
    | Customer Login / Password Reset
    |--------------------------------------------------------------------------
    */
    Route::prefix('user')->name('user.')->group(function () {
        // Login
        Route::get('login', [CustomerLoginController::class, 'showLoginForm'])
            ->name('login');
        Route::post('login', [CustomerLoginController::class, 'login'])
            ->name('login.submit');

        // Forgot / Reset Password
        Route::get('password/reset', [CustomerForgotPasswordController::class, 'showLinkRequestForm'])
            ->name('password.request');
        Route::post('password/email', [CustomerForgotPasswordController::class, 'sendResetLinkEmail'])
            ->name('password.email');

        Route::get('password/reset/{token}', [CustomerResetPasswordController::class, 'showResetForm'])
            ->name('password.reset');
        Route::post('password/reset', [CustomerResetPasswordController::class, 'reset'])
            ->name('password.update');
    });

    /*
    |--------------------------------------------------------------------------
    | Vendor Login / Password Reset
    |--------------------------------------------------------------------------
    */
    Route::prefix('vendor')->name('vendor.')->group(function () {
        // Login
        Route::get('login', [VendorLoginController::class, 'showLoginForm'])
            ->name('login');
        Route::post('login', [VendorLoginController::class, 'login'])
            ->name('login.submit');

        // Forgot / Reset Password
        Route::get('password/reset', [VendorForgotPasswordController::class, 'showLinkRequestForm'])
            ->name('password.request');
        Route::post('password/email', [VendorForgotPasswordController::class, 'sendResetLinkEmail'])
            ->name('password.email');

        Route::get('password/reset/{token}', [VendorResetPasswordController::class, 'showResetForm'])
            ->name('password.reset');
        Route::post('password/reset', [VendorResetPasswordController::class, 'reset'])
            ->name('password.update');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Login / Password Reset
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {
        // Login
        Route::get('login', [AdminLoginController::class, 'index'])
            ->name('login');
        Route::post('login', [AdminLoginController::class, 'login'])
            ->name('login.submit');

        // Forgot / Reset Password
        Route::get('password/reset', [AdminForgotPasswordController::class, 'showLinkRequestForm'])
            ->name('password.request');
        Route::post('password/email', [AdminForgotPasswordController::class, 'sendResetLinkEmail'])
            ->name('password.email');

        Route::get('password/reset/{token}', [AdminResetPasswordController::class, 'showResetForm'])
            ->name('password.reset');
        Route::post('password/reset', [AdminResetPasswordController::class, 'reset'])
            ->name('password.update');
    });

    /*
    |--------------------------------------------------------------------------
    | Customer Protected Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware(['checkUserRole:user'])->group(function () {
        Route::get('/', [CustomerLoginController::class, 'index'])
            ->name('home');
        Route::get('/cart', [CustomerCartController::class, 'index'])
            ->name('user.cart.index');
        Route::get('/checkout', [CustomerCheckoutController::class, 'showCheckoutForm'])
            ->name('user.checkout.index');
        Route::prefix('user')->name('user.')->group(function () {
            Route::post('logout', [CustomerLoginController::class, 'logout'])
                ->name('logout.submit');
            // Cart & Checkout
            Route::post('/cart/add', [CustomerCartController::class, 'add'])
                ->name('cart.add');
            Route::post('/cart/update', [CustomerCartController::class, 'update'])
                ->name('cart.update');
            Route::delete('/cart/delete/{id}', [CustomerCartController::class, 'delete'])
                ->name('cart.delete');
            Route::post('/checkout/shipping-rate', [CustomerShippingController::class, 'getShippingRate'])
                ->name('checkout.shipping.rate');
            Route::post('/checkout/apply-coupon', [CustomerCheckoutController::class, 'applyCoupon'])
                ->name('apply.coupon');

            Route::post('/checkout', [CustomerCheckoutController::class, 'process'])
                ->name('checkout.process');
            Route::get('/checkout/success', [CustomerCheckoutController::class, 'success'])
                ->name('checkout.success');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Vendor Protected Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkUserRole:vendor'])->group(function () {
        Route::prefix('vendor')->name('vendor.')->group(function () {
            Route::post('logout', [VendorLoginController::class, 'logout'])
                ->name('logout.submit');
            Route::get('dashboard', [VendorLoginController::class, 'dashboard'])
                ->name('dashboard')
                ->middleware('check.vendor.permission:manage dashboard');

            // Vendor resources
            Route::resource('categories', VendorCategoryController::class)
                ->middleware('check.vendor.permission:view categories');
            Route::resource('products', VendorProductController::class)
                ->middleware('check.vendor.permission:manage own products');
            Route::resource('brands', VendorBrandController::class)
                ->middleware('check.vendor.permission:view brands');
            Route::resource('coupons', VendorCouponController::class)
                ->middleware('check.vendor.permission:manage own coupons');
            Route::resource('orders', VendorOrderController::class)->except(['create', 'store'])
                ->middleware('check.vendor.permission:manage own orders');

            // Profile
            Route::middleware(['check.vendor.permission:manage own profile'])->group(function () {
                Route::get('profile', [VendorProfileController::class, 'index'])
                    ->name('profile.index');
                Route::get('profile/{profile}/edit', [VendorProfileController::class, 'edit'])
                    ->name('profile.edit');
                Route::put('profile/{profile}', [VendorProfileController::class, 'update'])
                    ->name('profile.update');
            });



            // Shipping
            Route::middleware(['check.vendor.permission:manage shipping options'])->group(function () {
                Route::get('shipping/methods', [VendorShippingMethodController::class, 'index'])->name('shipping.methods.index');
                Route::post('shipping/methods', [VendorShippingMethodController::class, 'store'])->name('shipping.methods.store');
                Route::resource('shipping/rates', VendorShippingRateController::class)->except(['show', 'edit']);
            });

            // Wallet
            Route::get('wallet', [VendorWalletController::class, 'index'])
                ->name('wallet.index')
                ->middleware('check.vendor.permission:view own wallet');
            Route::resource('wallet/withdraw', VendorWithdrawController::class)
                ->except(['show'])
                ->middleware('check.vendor.permission:request withdraw');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Protected Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkUserRole:admin'])->group(function () {

        Route::prefix('admin')->name('admin.')->group(function () {



            // Admins CRUD
            Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
            Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
            Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
            Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admins.edit');
            Route::put('/admins/{admin}', [AdminController::class, 'update'])->name('admins.update');
            Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy');

            // Assign roles
            Route::get('/admins/{admin}/roles', [AdminController::class, 'assignRoleForm'])->name('admins.assignRoleForm');
            Route::post('/admins/{admin}/roles', [AdminController::class, 'assignRole'])->name('admins.assignRole');


            Route::post('logout', [AdminLoginController::class, 'logout'])
                ->name('logout.submit');
            Route::get('dashboard', [AdminLoginController::class, 'dashboard'])
                ->name('dashboard')
                ->middleware('check.admin.permission:view dashboard');

            // Vendors
            Route::middleware(['check.admin.permission:manage vendors'])->group(function () {
                Route::get('vendors/pending', [AdminVendorController::class, 'pending'])
                    ->name('vendors.pending');
                Route::put('vendors/pending/{vendor}', [AdminVendorController::class, 'updateStatus'])
                    ->name('vendors.update.status');
                Route::resource('vendors', AdminVendorController::class)
                    ->except(['create', 'store']);
            });

            // Users
            Route::middleware(['check.admin.permission:manage users'])->group(function () {
                Route::resource('users', AdminUserController::class)
                    ->except(['create', 'store']);
                Route::put('users/restore/{user}', [AdminUserController::class, 'restore'])
                    ->name('users.restore');
            });

            // Admin Resources
            Route::resource('brands', AdminBrandController::class)
                ->middleware('check.admin.permission:manage brands');
            Route::resource('categories', AdminCategoryController::class)
                ->middleware('check.admin.permission:manage categories');
            Route::resource('coupons', AdminCouponController::class)
                ->middleware('check.admin.permission:manage coupons');
            Route::resource('orders', AdminOrderController::class)
                ->except(['create', 'store'])
                ->middleware('check.admin.permission:manage orders');

            Route::get('roles/get-permissions/{guard}', [AdminRoleController::class, 'getPermissions'])->name('roles.getPermissions');
            Route::resource('roles', AdminRoleController::class)->middleware('check.admin.permission:Manage Roles');
            Route::resource('permissions', AdminPermissionController::class)->middleware('check.admin.permission:Manage Permissions');

            Route::get('vendors/{id}/assign-role', [AdminVendorController::class, 'showAssignRoleForm'])->name('vendors.assignRoleForm');
            Route::post('vendors/{id}/assign-role', [AdminVendorController::class, 'assignRole'])->name('vendors.assignRole');


            // Profile
            Route::resource('profile', AdminProfileController::class)
                ->except(['create', 'store', 'show'])
                ->middleware('check.admin.permission:manage profile');

            // Products
            Route::middleware(['check.admin.permission:manage products'])->group(function () {
                Route::resource('products', AdminProductController::class)
                    ->except(['create', 'store']);
                Route::put('products/restore/{product}', [AdminProductController::class, 'restore'])
                    ->name('products.restore');
            });

            // Shipping
            Route::middleware(['check.admin.permission:manage shipping'])->group(function () {
                Route::resource('shipping/methods', AdminShippingMethodController::class)
                    ->except('show');
                Route::resource('cities', AdminShippingCityController::class)
                    ->except('show');
                Route::resource('regions', AdminShippingRegionController::class)
                    ->except('show');
            });


            // Finance
            Route::middleware(['check.admin.permission:manage finance'])->group(function () {
                Route::get('finance', [AdminFinanceController::class, 'index'])
                    ->name('finance.index');
                Route::resource('withdraw', AdminWithdrawController::class)
                    ->except(['create', 'store', 'show', 'edit', 'update', 'destroy']);
                Route::post('withdraw/approve', [AdminWithdrawController::class, 'approve'])
                    ->name('withdraw.approve');
                Route::post('withdraw/reject', [AdminWithdrawController::class, 'reject'])
                    ->name('withdraw.reject');
            });

            // Emails
            Route::middleware(['check.admin.permission:manage emails'])->group(function () {
                Route::resource('email', AdminEmailController::class)->except(['show', 'create', 'store', 'destroy']);
                Route::get('email/test', [AdminEmailController::class, 'emailTest'])
                    ->name('email.test');
                Route::post('email/send', [AdminEmailController::class, 'sendEmailTest'])
                    ->name('email.test.send');
            });

            // Chats
            Route::middleware(['check.admin.permission:manage chats'])->group(function () {
                Route::resource('chats', AdminChatController::class);
                Route::post('chats/{chat}/send-message', [AdminChatController::class, 'sendMessage'])
                    ->name('chats.send.message');
            });
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Payment Callback
    |--------------------------------------------------------------------------
    */
    Route::match(['GET', 'POST'], '/payment/callback', [AdminPaymentController::class, 'callback'])
        ->name('payment.callback');
    Route::post('/payment/process', [AdminPaymentController::class, 'paymentProcess'])
        ->name('payment.process');
    Route::get('/payment/success', [AdminPaymentController::class, 'success'])
        ->name('payment.success');
    Route::get('/payment/failed', [AdminPaymentController::class, 'failed'])
        ->name('payment.failed');
});
