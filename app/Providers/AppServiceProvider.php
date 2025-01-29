<?php

namespace App\Providers;

use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\User\UserService;
use App\Services\User\UserServiceImpl;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class, function () {
            return new UserRepository(new User());
        });

        $this->app->bind(UserService::class, UserServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
