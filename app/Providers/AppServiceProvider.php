<?php

namespace App\Providers;

use App\Models\Master;
use App\Models\User;
use App\Observers\MasterObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use Vonage\Client\Credentials\Basic;
use Vonage\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Client::class, function() {
            return new Client(new Basic(env('VONAGE_KEY'),env('VONAGE_SECRET')));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Master::observe(MasterObserver::class);
    }
}
