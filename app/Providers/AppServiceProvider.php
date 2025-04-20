<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ConcessionRepositoryInterface;
use App\Repositories\ConcessionRepository;
use App\Repositories\OrderRepository;
use App\Repositories\Interfaces\OrderRepositoryInterface;
class AppServiceProvider extends ServiceProvider

{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ConcessionRepositoryInterface::class, ConcessionRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
