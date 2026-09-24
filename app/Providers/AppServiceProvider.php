<?php

namespace App\Providers;

use App\Models\Item;
use App\Models\ItemTransaction;
use App\Observers\ItemObserver;
use App\Observers\ItemTransactionObserver;
use Illuminate\Support\ServiceProvider;

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
        Item::observe(ItemObserver::class);
        ItemTransaction::observe(ItemTransactionObserver::class);
    }
}
