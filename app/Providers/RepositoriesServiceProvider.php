<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Repository
use App\Repositories\Admin\AdminAuthRepository;
use App\Repositories\User\UserAuthRepository;
use App\Repositories\User\PurchasePlanRepositor;
use App\Repositories\Broker\BrokerAuthRepository;
use App\Repositories\Broker\PlanRepository;
use App\Repositories\Broker\BrokerRepository;
use App\Repositories\Admin\SalesMarketingRepository;
use App\Repositories\Payment\StripePaymentRepository;

// Interface
use App\Interfaces\Admin\AdminAuthInterface;
use App\Interfaces\User\UserAuthInterface;
use App\Interfaces\User\PurchasePlanInterface;
use App\Interfaces\Broker\BrokerAuthInterface;
use App\Interfaces\Broker\BrokerInterface;
use App\Interfaces\Broker\PlanInterface;
use App\Interfaces\Admin\SalesMarketingInterface;
use App\Interfaces\Payment\StripePaymentInterface;


class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //Admin
        $this->app->bind(AdminAuthInterface::class, AdminAuthRepository::class);
        
        //users
        $this->app->bind(UserAuthInterface::class, UserAuthRepository::class);
        $this->app->bind(PurchasePlanInterface::class, PurchasePlanRepositor::class);
        
        //Broker
        $this->app->bind(BrokerAuthInterface::class, BrokerAuthRepository::class);
        $this->app->bind(BrokerInterface::class, BrokerRepository::class);
        $this->app->bind(PlanInterface::class, PlanRepository::class);

        //SalesMarketing
        $this->app->bind(SalesMarketingInterface::class, SalesMarketingRepository::class);

        //Payment
        $this->app->bind(StripePaymentInterface::class, StripePaymentRepository::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
