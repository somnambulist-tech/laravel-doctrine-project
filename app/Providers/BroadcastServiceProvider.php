<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

/**
 * Class BroadcastServiceProvider
 *
 * @package    App\Providers
 * @subpackage App\Providers\BroadcastServiceProvider
 */
class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        /*
         * Authenticate the user's personal channel...
         */
        Broadcast::channel(
            'App.Entities.User.{userId}', function ($user, $userId) {
            return (int)$user->getId() === (int)$userId;
        });
    }
}
