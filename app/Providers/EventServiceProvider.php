<?php

namespace App\Providers;

use App\Models\RentalOrder;
use App\Observers\RentalOrderObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [];

    public function boot()
    {
        RentalOrder::observe(RentalOrderObserver::class);
    }
}
