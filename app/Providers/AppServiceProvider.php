<?php

namespace App\Providers;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Khai báo với Laravel: Nếu ai (như AuthService) cần UserRepositoryInterface,
        // hãy tự động đưa cho họ class UserRepository (chuẩn Dependency Injection).
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
