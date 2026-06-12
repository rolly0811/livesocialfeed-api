<?php

namespace App\Providers;

use App\Contracts\Notifications\EmailNotificationInterface;
use App\Services\EmailNotification\Providers\TurboSmtpProvider;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            EmailNotificationInterface::class, 
            TurboSmtpProvider::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();
    }
}
