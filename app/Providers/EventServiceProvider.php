<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Events\OrderUpdated;
use App\Listeners\AddVendorTransaction;
use App\Listeners\NotifyVendorsOnOrderPlaced;
use App\Models\Admin;
use App\Models\User;
use App\Models\Vendor;
use App\Observers\AdminObserver;
use App\Observers\UserObserver;
use App\Observers\VendorObserver;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $listen = [
        OrderUpdated::class => [
            AddVendorTransaction::class,
        ],
        OrderPlaced::class => [
            NotifyVendorsOnOrderPlaced::class,
        ]
    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Vendor::observe(VendorObserver::class);
        Admin::observe(AdminObserver::class);
        User::observe(UserObserver::class);
    }
}
