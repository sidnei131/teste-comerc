<?php

namespace App\Providers;

use App\Events\OrderCreated;
use App\Listeners\SendOrderEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderCreated::class => [
            SendOrderEmail::class,
        ],
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        parent::boot();
    }
}
