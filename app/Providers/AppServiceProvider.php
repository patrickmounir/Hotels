<?php

namespace App\Providers;

use App\Exceptions\ApiHandler;
use App\Responses\ApiResponder;
use App\Responses\Responder;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ExceptionHandler::class, ApiHandler::class);
        $this->app->singleton(Responder::class, ApiResponder::class);
    }
}
