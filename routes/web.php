<?php


// Common Controllers
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Common\Auth\RegisterController;
use App\Http\Controllers\Common\Auth\Socialite\GoogleController as SocialiteGoogleController;
use App\Http\Controllers\Common\Localization\LanguageController as LocalizationLanguageController;

// Admin Controllers
use App\Http\Controllers\Admin\Analytics\GoogleAnalyticsController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Access\PermissionController as AdminPermissionController;
use App\Http\Controllers\Admin\Access\RoleController as AdminRoleController;
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
use App\Http\Controllers\Admin\Chat\VendorChatController as AdminVendorChatController;
use App\Http\Controllers\Admin\Chat\CustomerChatController as AdminCustomerChatController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
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
use App\Http\Controllers\Vendor\Auth\EmailVerificationController as VendorEmailVerificationController;
use App\Http\Controllers\Vendor\DashboardController as VendorDashboardController;
use App\Http\Controllers\Vendor\Chat\ChatController as VendorChatController;

// Customer Controllers
use App\Http\Controllers\Customer\Auth\LoginController as CustomerLoginController;
use App\Http\Controllers\Customer\Auth\ForgotPasswordController as CustomerForgotPasswordController;
use App\Http\Controllers\Customer\Auth\ResetPasswordController as CustomerResetPasswordController;
use App\Http\Controllers\Customer\Cart\CartController as CustomerCartController;
use App\Http\Controllers\Customer\Chat\ChatController as CustomerChatController;
use App\Http\Controllers\Customer\Checkout\CheckoutController as CustomerCheckoutController;
use App\Http\Controllers\Customer\Shipping\ShippingController as CustomerShippingController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Language
|--------------------------------------------------------------------------
*/

Route::get('/{language}/change-language', [LocalizationLanguageController::class, 'changeLanguage'])->name('change.language');
Broadcast::routes(['middleware' => ['web']]);

// Admin channels
Broadcast::channel('chat.admin.{adminId}', function ($user, $adminId) {
    return auth('admins')->check() && auth('admins')->id() == $adminId;
});

// Vendor channels
Broadcast::channel('chat.vendor.{vendorId}', function ($user, $vendorId) {
    return auth('vendors')->check() && auth('vendors')->id() == $vendorId;
});

// Customer channels
Broadcast::channel('chat.customer.{customerId}', function ($user, $customerId) {
    return auth('web')->check() && auth('web')->id() == $customerId;
});


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


    // Public Pages
    Route::get('/', [CustomerLoginController::class, 'index'])->name('home');
    Route::get('/shop', [App\Http\Controllers\Customer\ShopController::class, 'index'])->name('shop');
    Route::get('/product/{product}', [CustomerProductController::class, 'show'])->name('product.show');
    Route::get('/about', [App\Http\Controllers\Customer\PageController::class, 'about'])->name('about');
    Route::get('/contact', [App\Http\Controllers\Customer\PageController::class, 'contact'])->name('contact');
    Route::post('/contact', [App\Http\Controllers\Customer\PageController::class, 'contactSubmit'])->name('contact.submit');
    Route::get('/privacy', [App\Http\Controllers\Customer\PageController::class, 'privacy'])->name('privacy');
    Route::get('/terms', [App\Http\Controllers\Customer\PageController::class, 'terms'])->name('terms');
    Route::get('/shipping-policy', [App\Http\Controllers\Customer\PageController::class, 'shipping'])->name('shipping.policy');
    Route::get('/returns-policy', [App\Http\Controllers\Customer\PageController::class, 'returns'])->name('returns.policy');

    // FAQ
    Route::get('/faq', [App\Http\Controllers\Customer\FaqController::class, 'index'])->name('faq');

    // Public Cart Routes (Accessible by Guests)
    Route::get('/cart', [CustomerCartController::class, 'index'])->name('user.cart.index');
    Route::post('/user/cart/add', [CustomerCartController::class, 'add'])->name('cart.add');
    Route::get('/user/cart/data', [CustomerCartController::class, 'getData'])->name('cart.data');
    Route::post('/user/cart/update', [CustomerCartController::class, 'update'])->name('cart.update');
    Route::delete('/user/cart/delete/{id}', [CustomerCartController::class, 'delete'])->name('cart.delete');
    Route::post('/user/checkout/shipping-rate', [CustomerShippingController::class, 'getShippingRate'])->name('checkout.shipping.rate');
    Route::post('/user/checkout/apply-coupon', [CustomerCheckoutController::class, 'applyCoupon'])->name('apply.coupon');


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


        // Email Verification
        Route::get('email/verify', [VendorEmailVerificationController::class, 'notice'])
            ->middleware('auth:vendors')
            ->name('verification.notice');

        Route::get('email/verify/{id}/{hash}', [VendorEmailVerificationController::class, 'verify'])
            ->middleware(['auth:vendors', 'signed'])
            ->name('verification.verify');

        Route::post('email/verification-notification', [VendorEmailVerificationController::class, 'resend'])
            ->middleware(['auth:vendors', 'throttle:6,1'])
            ->name('verification.send');
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

        Route::get('customer/chat', [CustomerChatController::class, 'loadMessages'])
            ->name('customer.chats.load.messages');
        Route::post('customer/chat/send', [CustomerChatController::class, 'sendMessage'])
            ->name('customer.chat.send.message');

        Route::get('/checkout', [CustomerCheckoutController::class, 'showCheckoutForm'])
            ->name('user.checkout.index');
        Route::prefix('user')->name('user.')->group(function () {
            Route::post('logout', [CustomerLoginController::class, 'logout'])
                ->name('logout.submit');

            // Checkout Process
            Route::post('/checkout', [CustomerCheckoutController::class, 'process'])
                ->name('checkout.process');
            Route::get('/checkout/success', [CustomerCheckoutController::class, 'success'])
                ->name('checkout.success');

            // Profile
            Route::get('/profile', [App\Http\Controllers\Customer\ProfileController::class, 'index'])
                ->name('profile.index');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Vendor Protected Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkUserRole:vendor'])->group(function () {

        Route::get('vendor/chats/vendor/messages', [VendorChatController::class, 'loadMessages'])
            ->name('vendor.chats.load.messages');
        Route::post('vendor/chat/send', [VendorChatController::class, 'sendMessage'])
            ->middleware('check.vendor.permission:Create Data')
            ->name('vendor.chat.send.message');

        Route::prefix('vendor')->name('vendor.')->group(function () {
            Route::post('logout', [VendorLoginController::class, 'logout'])
                ->name('logout.submit');
            Route::get('dashboard', [VendorDashboardController::class, 'index'])
                ->name('dashboard')
                ->middleware('check.vendor.permission:manage dashboard');

            // Categories
            Route::resource('categories', VendorCategoryController::class)
                ->only(['index'])
                ->middleware('check.vendor.permission:view categories');

            // Products
            Route::resource('products', VendorProductController::class)
                ->middleware('check.vendor.permission:manage own products');

            // Brands
            Route::resource('brands', VendorBrandController::class)
                ->only(['index'])
                ->middleware('check.vendor.permission:view brands');

            // Coupons
            Route::resource('coupons', VendorCouponController::class)
                ->except(['store', 'update', 'destroy'])
                ->middleware('check.vendor.permission:manage own coupons');
            Route::post('coupons', [VendorCouponController::class, 'store'])
                ->middleware('check.vendor.permission:Create Data,manage own coupons')
                ->name('coupons.store');
            Route::put('coupons/{coupon}', [VendorCouponController::class, 'update'])
                ->middleware('check.vendor.permission:Update Data,manage own coupons')
                ->name('coupons.update');
            Route::delete('coupons/{coupon}', [VendorCouponController::class, 'destroy'])
                ->middleware('check.vendor.permission:Delete Data,manage own coupons')
                ->name('coupons.destroy');

            // Orders
            Route::resource('orders', VendorOrderController::class)
                ->except(['create', 'store', 'update', 'destroy'])
                ->middleware('check.vendor.permission:manage own orders');
            Route::put('orders/{order}', [VendorOrderController::class, 'update'])
                ->middleware('check.vendor.permission:Update Data,manage own orders')
                ->name('orders.update');
            Route::delete('orders/{order}', [VendorOrderController::class, 'destroy'])
                ->middleware('check.vendor.permission:Delete Data,manage own orders')
                ->name('orders.destroy');

            // Profile
            Route::middleware(['check.vendor.permission:manage own profile'])->group(function () {
                Route::get('profile', [VendorProfileController::class, 'index'])
                    ->name('profile.index');
                Route::get('profile/{profile}/edit', [VendorProfileController::class, 'edit'])
                    ->name('profile.edit');
                Route::put('profile/{profile}', [VendorProfileController::class, 'update'])
                    ->middleware('check.vendor.permission:Update Data')
                    ->name('profile.update');
            });

            // Shipping
            Route::middleware(['check.vendor.permission:manage shipping options'])->group(function () {
                Route::get('shipping/methods', [VendorShippingMethodController::class, 'index'])
                    ->name('shipping.methods.index');
                Route::post('shipping/methods', [VendorShippingMethodController::class, 'store'])
                    ->middleware('check.vendor.permission:Create Data')
                    ->name('shipping.methods.store');
                // Route::resource('shipping/rates', VendorShippingRateController::class)
                //     ->except(['show', 'edit']);
                Route::resource('shipping/rates', VendorShippingRateController::class)
                    ->only(['index']);
                Route::post('shipping/rates', [VendorShippingRateController::class, 'store'])
                    ->middleware('check.vendor.permission:Create Data,view shipping rates')
                    ->name('rates.store');
            });

            // Wallet
            Route::get('wallet', [VendorWalletController::class, 'index'])
                ->name('wallet.index')
                ->middleware('check.vendor.permission:view own wallet');
            Route::resource('wallet/withdraw', VendorWithdrawController::class)
                ->except(['show', 'store', 'update', 'destroy'])
                ->middleware('check.vendor.permission:request withdraw');
            Route::post('wallet/withdraw', [VendorWithdrawController::class, 'store'])
                ->middleware('check.vendor.permission:Create Data,request withdraw')
                ->name('withdraw.store');
            Route::put('wallet/withdraw/{withdraw}', [VendorWithdrawController::class, 'update'])
                ->middleware('check.vendor.permission:Update Data,request withdraw')
                ->name('withdraw.update');
            Route::delete('wallet/withdraw/{withdraw}', [VendorWithdrawController::class, 'destroy'])
                ->middleware('check.vendor.permission:Delete Data,request withdraw')
                ->name('withdraw.destroy');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Protected Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['checkUserRole:admin'])->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/dashboard/analytics', [GoogleAnalyticsController::class, 'dashboard'])->name('dashboard.analytics');
            // Admins CRUD
            Route::get('/admins', [AdminController::class, 'index'])
                ->name('admins.index');
            Route::get('/admins/create', [AdminController::class, 'create'])
                ->name('admins.create');
            Route::post('/admins', [AdminController::class, 'store'])
                ->name('admins.store')
                ->middleware('check.admin.permission:Create Data');
            Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])
                ->name('admins.edit');
            Route::put('/admins/{admin}', [AdminController::class, 'update'])
                ->name('admins.update')
                ->middleware('check.admin.permission:Update Data');
            Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])
                ->name('admins.destroy')
                ->middleware('check.admin.permission:Delete Data');

            // Assign roles
            Route::get('/admins/{admin}/roles', [AdminController::class, 'assignRoleForm'])
                ->name('admins.assignRoleForm');
            Route::post('/admins/{admin}/roles', [AdminController::class, 'assignRole'])
                ->name('admins.assignRole')
                ->middleware('check.admin.permission:Update Data');

            Route::get('vendors/{id}/assign-role', [AdminVendorController::class, 'showAssignRoleForm'])->name('vendors.assignRoleForm');
            Route::post('vendors/{id}/assign-role', [AdminVendorController::class, 'assignRole'])
                ->name('vendors.assignRole')
                ->middleware('check.admin.permission:Update Data');

            // Roles
            Route::resource('roles', AdminRoleController::class)
                ->except(['show', 'store', 'update', 'destroy'])
                ->middleware('check.admin.permission:Manage Roles');
            Route::post('roles', [AdminRoleController::class, 'store'])
                ->middleware('check.admin.permission:Create Data,Manage Roles')
                ->name('roles.store');
            Route::put('roles/{role}', [AdminRoleController::class, 'update'])
                ->middleware('check.admin.permission:Update Data,Manage Roles')
                ->name('roles.update');
            Route::delete('roles/{role}', [AdminRoleController::class, 'destroy'])
                ->middleware('check.admin.permission:Delete Data,Manage Roles')
                ->name('roles.destroy');
            Route::get('roles/get-permissions/{guard}', [AdminRoleController::class, 'getPermissions'])
                ->name('roles.getPermissions');

            // Permissions
            Route::resource('permissions', AdminPermissionController::class)
                ->except(['store', 'update', 'destroy'])
                ->middleware('check.admin.permission:Manage Permissions');
            Route::post('permissions', [AdminPermissionController::class, 'store'])
                ->middleware('check.admin.permission:Create Data,Manage Permissions')
                ->name('permissions.store');
            Route::put('permissions/{permission}', [AdminPermissionController::class, 'update'])
                ->middleware('check.admin.permission:Update Data,Manage Permissions')
                ->name('permissions.update');
            Route::delete('permissions/{permission}', [AdminPermissionController::class, 'destroy'])
                ->middleware('check.admin.permission:Delete Data,Manage Permissions')
                ->name('permissions.destroy');



            Route::post('logout', [AdminLoginController::class, 'logout'])
                ->name('logout.submit');
            Route::get('dashboard', [AdminDashboardController::class, 'index'])
                ->name('dashboard')
                ->middleware('check.admin.permission:view dashboard');

            // Vendors
            Route::middleware(['check.admin.permission:manage vendors'])->group(function () {
                Route::get('vendors/pending', [AdminVendorController::class, 'pending'])
                    ->name('vendors.pending');
                Route::put('vendors/pending/{vendor}', [AdminVendorController::class, 'updateStatus'])
                    ->name('vendors.update.status')->middleware('check.admin.permission:Update Data');
                Route::resource('vendors', AdminVendorController::class)
                    ->except(['create', 'store', 'update', 'destroy']);
                Route::put('vendors/{vendor}', [AdminVendorController::class, 'update'])
                    ->middleware('check.admin.permission:Update Data')
                    ->name('vendors.update');
                Route::delete('vendors/{vendor}', [AdminVendorController::class, 'destroy'])
                    ->middleware('check.admin.permission:Delete Data')
                    ->name('vendors.destroy');
            });

            // Users
            Route::middleware(['check.admin.permission:manage users'])->group(function () {
                Route::resource('users', AdminUserController::class)
                    ->except(['create', 'store', 'update', 'destroy']);
                Route::put('users/{user}', [AdminUserController::class, 'update'])
                    ->middleware('check.admin.permission:Update Data')
                    ->name('users.update');
                Route::delete('users/{user}', [AdminUserController::class, 'destroy'])
                    ->middleware('check.admin.permission:Delete Data')
                    ->name('users.destroy');
                Route::put('users/restore/{user}', [AdminUserController::class, 'restore'])
                    ->name('users.restore')->middleware('check.admin.permission:Update Data');
            });

            // Admin Resources
            Route::resource('brands', AdminBrandController::class)
                ->except(['store', 'update', 'destroy'])
                ->middleware('check.admin.permission:manage brands');
            Route::post('brands', [AdminBrandController::class, 'store'])
                ->middleware('check.admin.permission:Create Data,manage brands')
                ->name('brands.store');
            Route::put('brands/{brand}', [AdminBrandController::class, 'update'])
                ->middleware('check.admin.permission:Update Data,manage brands')
                ->name('brands.update');
            Route::delete('brands/{brand}', [AdminBrandController::class, 'destroy'])
                ->middleware('check.admin.permission:Delete Data,manage brands')
                ->name('brands.destroy');

            Route::resource('categories', AdminCategoryController::class)
                ->except(['store', 'update', 'destroy'])
                ->middleware('check.admin.permission:manage categories');
            Route::post('categories', [AdminCategoryController::class, 'store'])
                ->middleware('check.admin.permission:Create Data,manage categories')
                ->name('categories.store');
            Route::put('categories/{category}', [AdminCategoryController::class, 'update'])
                ->middleware('check.admin.permission:Update Data,manage categories')
                ->name('categories.update');
            Route::delete('categories/{category}', [AdminCategoryController::class, 'destroy'])
                ->middleware('check.admin.permission:Delete Data,manage categories')
                ->name('categories.destroy');

            Route::resource('coupons', AdminCouponController::class)
                ->except(['store', 'update', 'destroy'])
                ->middleware('check.admin.permission:manage coupons');
            Route::post('coupons', [AdminCouponController::class, 'store'])
                ->middleware('check.admin.permission:Create Data,manage coupons')
                ->name('coupons.store');
            Route::put('coupons/{coupon}', [AdminCouponController::class, 'update'])
                ->middleware('check.admin.permission:Update Data,manage coupons')
                ->name('coupons.update');
            Route::delete('coupons/{coupon}', [AdminCouponController::class, 'destroy'])
                ->middleware('check.admin.permission:Delete Data,manage coupons')
                ->name('coupons.destroy');

            Route::resource('orders', AdminOrderController::class)
                ->except(['create', 'store', 'update', 'destroy'])
                ->middleware('check.admin.permission:manage orders');
            Route::put('orders/{order}', [AdminOrderController::class, 'update'])
                ->middleware('check.admin.permission:Update Data,manage orders')
                ->name('orders.update');
            Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])
                ->middleware('check.admin.permission:Delete Data,manage orders')
                ->name('orders.destroy');



            // Profile
            Route::resource('profile', AdminProfileController::class)
                ->except(['create', 'store', 'show', 'update', 'destroy'])
                ->middleware('check.admin.permission:manage profile');
            Route::put('profile/{profile}', [AdminProfileController::class, 'update'])
                ->middleware('check.admin.permission:Update Data,manage profile')
                ->name('profile.update');
            Route::delete('profile/{profile}', [AdminProfileController::class, 'destroy'])
                ->middleware('check.admin.permission:Delete Data,manage profile')
                ->name('profile.destroy');

            // Products
            Route::middleware(['check.admin.permission:manage products'])->group(function () {
                Route::resource('products', AdminProductController::class)
                    ->except(['create', 'store', 'update', 'destroy']);
                Route::put('products/{product}', [AdminProductController::class, 'update'])
                    ->middleware('check.admin.permission:Update Data')
                    ->name('products.update');
                Route::delete('products/{product}', [AdminProductController::class, 'destroy'])
                    ->middleware('check.admin.permission:Delete Data')
                    ->name('products.destroy');
                Route::put('products/restore/{product}', [AdminProductController::class, 'restore'])
                    ->middleware('check.admin.permission:Update Data')
                    ->name('products.restore');
            });

            // Shipping
            Route::middleware(['check.admin.permission:manage shipping'])->group(function () {
                // Methods
                Route::resource('shipping/methods', AdminShippingMethodController::class)
                    ->except(['show', 'store', 'update', 'destroy'])
                    ->middleware('check.admin.permission:manage shipping');
                Route::post('shipping/methods', [AdminShippingMethodController::class, 'store'])
                    ->middleware('check.admin.permission:Create Data,manage shipping')
                    ->name('shipping.methods.store');
                Route::put('shipping/methods/{method}', [AdminShippingMethodController::class, 'update'])
                    ->middleware('check.admin.permission:Update Data,manage shipping')
                    ->name('shipping.methods.update');
                Route::delete('shipping/methods/{method}', [AdminShippingMethodController::class, 'destroy'])
                    ->middleware('check.admin.permission:Delete Data,manage shipping')
                    ->name('shipping.methods.destroy');

                // Cities
                Route::resource('cities', AdminShippingCityController::class)
                    ->except(['show', 'store', 'update', 'destroy'])
                    ->middleware('check.admin.permission:manage shipping');
                Route::post('cities', [AdminShippingCityController::class, 'store'])
                    ->middleware('check.admin.permission:Create Data,manage shipping')
                    ->name('cities.store');
                Route::put('cities/{city}', [AdminShippingCityController::class, 'update'])
                    ->middleware('check.admin.permission:Update Data,manage shipping')
                    ->name('cities.update');
                Route::delete('cities/{city}', [AdminShippingCityController::class, 'destroy'])
                    ->middleware('check.admin.permission:Delete Data,manage shipping')
                    ->name('cities.destroy');

                // Regions
                Route::resource('regions', AdminShippingRegionController::class)
                    ->except(['show', 'store', 'update', 'destroy'])
                    ->middleware('check.admin.permission:manage shipping');
                Route::post('regions', [AdminShippingRegionController::class, 'store'])
                    ->middleware('check.admin.permission:Create Data,manage shipping')
                    ->name('regions.store');
                Route::put('regions/{region}', [AdminShippingRegionController::class, 'update'])
                    ->middleware('check.admin.permission:Update Data,manage shipping')
                    ->name('regions.update');
                Route::delete('regions/{region}', [AdminShippingRegionController::class, 'destroy'])
                    ->middleware('check.admin.permission:Delete Data,manage shipping')
                    ->name('regions.destroy');
            });


            // Finance
            Route::middleware(['check.admin.permission:manage finance'])->group(function () {
                Route::get('finance', [AdminFinanceController::class, 'index'])
                    ->name('finance.index');
                Route::resource('withdraw', AdminWithdrawController::class)
                    ->except(['create', 'store', 'show', 'edit', 'update', 'destroy']);
                Route::post('withdraw/approve', [AdminWithdrawController::class, 'approve'])
                    ->middleware('check.admin.permission:Update Data')
                    ->name('withdraw.approve');
                Route::post('withdraw/reject', [AdminWithdrawController::class, 'reject'])
                    ->middleware('check.admin.permission:Update Data')
                    ->name('withdraw.reject');
            });

            // Emails
            Route::middleware(['check.admin.permission:manage emails'])->group(function () {
                Route::resource('email', AdminEmailController::class)->except(['show', 'create', 'store', 'destroy', 'update']);
                Route::put('email/{email}', [AdminEmailController::class, 'update'])
                    ->middleware('check.admin.permission:Update Data')
                    ->name('email.update');
                Route::get('email/test', [AdminEmailController::class, 'emailTest'])
                    ->name('email.test');
                Route::post('email/send', [AdminEmailController::class, 'sendEmailTest'])
                    ->middleware('check.admin.permission:Update Data')
                    ->name('email.test.send');
            });

            // Chats
            Route::middleware(['check.admin.permission:manage chats'])->group(function () {
                Route::resource('vendor-chats', AdminVendorChatController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
                Route::post('chats/vendor-chats/{receiverId}/send', [AdminVendorChatController::class, 'sendMessage'])
                    ->middleware('check.admin.permission:Create Data')
                    ->name('chats.vendor-chat.send.message');

                Route::resource('customer-chats', AdminCustomerChatController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
                Route::post('chats/customer-chats/{receiverId}/send', [AdminCustomerChatController::class, 'sendMessage'])
                    ->middleware('check.admin.permission:Create Data')
                    ->name('chats.customer-chat.send.message');
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
