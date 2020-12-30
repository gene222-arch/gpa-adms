<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * Todo
     * Create a middleware for the broadcast
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes([]); // this works for my api
        require base_path('routes/channels.php');
    }
}
