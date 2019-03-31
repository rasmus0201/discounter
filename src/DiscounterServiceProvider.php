<?php

namespace Bundsgaard\Discounter;

use Illuminate\Support\ServiceProvider;

class DiscounterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Discountable::class, SimpleDiscounter::class);
    }
}
