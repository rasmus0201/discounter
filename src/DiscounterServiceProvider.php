<?php

namespace Bundsgaard\Discounter;

use Illuminate\Support\ServiceProvider;

/**
 * @codeCoverageIgnore
 */
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
        $this->app->bind('Bundsgaard\Discounter\Contracts\Discountable', SimpleDiscounter::class);
        $this->app->bind('Bundsgaard\Discounter\DiscountTable', DiscountTable::class);
    }
}
