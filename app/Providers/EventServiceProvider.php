<?php

namespace App\Providers;

use App\Events\OrderUpdated;
use App\Listeners\AddVendorTransaction;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $listen = [
        OrderUpdated::class => [
            AddVendorTransaction::class,
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
        //
    }
}
