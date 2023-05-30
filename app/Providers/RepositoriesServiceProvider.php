<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Repository
use App\Repositories\Admin\AdminAuthRepository;
use App\Repositories\User\UserAuthRepository;
use App\Repositories\Broker\BrokerAuthRepository;
use App\Repositories\Admin\SalesMarketingRepository;

// Interface
use App\Interfaces\Admin\AdminAuthInterface;
use App\Interfaces\User\UserAuthInterface;
use App\Interfaces\Broker\BrokerAuthInterface;
use App\Interfaces\Admin\SalesMarketingInterface;


class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AdminAuthInterface::class, AdminAuthRepository::class);
        $this->app->bind(UserAuthInterface::class, UserAuthRepository::class);
        $this->app->bind(BrokerAuthInterface::class, BrokerAuthRepository::class);
        $this->app->bind(SalesMarketingInterface::class, SalesMarketingRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
