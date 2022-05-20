<?php

namespace App\Providers;

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
        $this->app->singleton(
            \App\Repositories\User\UserRepositoryInterface::class,
            \App\Repositories\User\UserRepositoryEloquent::class,
        );
        
        $this->app->singleton(
            \App\Repositories\Product\ProductRepositoryInterface::class,
            \App\Repositories\Product\ProductRepositoryEloquent::class,
        );

        $this->app->singleton(
            \App\Repositories\Order\OrderRepositoryInterface::class,
            \App\Repositories\Order\OrderRepositoryEloquent::class,
        );
        
        $this->app->singleton(
            \App\Repositories\Order_Detail\OrderDetailRepositoryInterface::class,
            \App\Repositories\Order_Detail\OrderDetailRepositoryEloquent::class,
        );
        
        $this->app->singleton(
            \App\Repositories\Customer\CustomerRepositoryInterface::class,
            \App\Repositories\Customer\CustomerRepositoryEloquent::class,
        );

        $this->app->singleton(
            \App\Repositories\Category\CategoryRepositoryInterface::class,
            \App\Repositories\Category\CategoryRepositoryEloquent::class,
        );

        $this->app->singleton(
            \App\Repositories\KPI\KPIRepositoryInterface::class,
            \App\Repositories\KPI\KPIRepositoryEloquent::class,
        );

        $this->app->singleton(
            \App\Repositories\Checkin\CheckinRepositoryInterface::class,
            \App\Repositories\Checkin\CheckinRepositoryEloquent::class,
        );

        $this->app->singleton(
            \App\Repositories\Area\AreaRepositoryInterface::class,
            \App\Repositories\Area\AreaRepositoryEloquent::class,
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
