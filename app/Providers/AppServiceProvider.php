<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use App\Contracts\IBankingService;
use App\Contracts\ILoggingService;
use App\Services\BankingService;
use App\Services\LoggingService;


use App\Services\Contracts\CreateAccountServiceInterface;
use App\Services\CreateAccountService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(IBankingService::class, BankingService::class);
        $this->app->bind(ILoggingService::class, LoggingService::class);


        $this->app->bind(
            CreateAccountServiceInterface::class,
            CreateAccountService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
