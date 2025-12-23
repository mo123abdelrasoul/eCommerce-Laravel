<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('email_settings')) {
            $settings = DB::table('email_settings')->first();

            if ($settings) {
                Config::set('mail.default', $settings->mailer);
                Config::set('mail.mailers.smtp.host', $settings->host);
                Config::set('mail.mailers.smtp.port', $settings->port);
                Config::set('mail.mailers.smtp.username', $settings->username);
                Config::set('mail.mailers.smtp.password', $settings->password);
                Config::set('mail.mailers.smtp.encryption', $settings->encryption);
                Config::set('mail.from.address', $settings->from_address);
                Config::set('mail.from.name', $settings->from_name);
            }
        }
    View::composer('customer.layouts.app', function ($view) {
        $cart = Session::get('cart', []);
        $products = collect();

        if (!empty($cart)) {
            $products = Product::select('id', 'name', 'image', 'price')
                ->whereIn('id', array_keys($cart))
                ->get();
        }

        $view->with(compact('products', 'cart'));
    });
    }
}
