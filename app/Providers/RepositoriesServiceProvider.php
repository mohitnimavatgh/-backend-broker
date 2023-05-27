<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Repository
use App\Repositories\Admin\AdminAuthRepository;
use App\Repositories\User\UserAuthRepository;

// Interface
use App\Interfaces\Admin\AdminAuthInterface;
use App\Interfaces\User\UserAuthInterface;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AdminAuthInterface::class, AdminAuthRepository::class);
        $this->app->bind(UserAuthInterface::class, UserAuthRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
