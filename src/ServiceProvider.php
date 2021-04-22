<?php


namespace Hooklife\QueryBuilder;

use Hooklife\QueryBuilder\Console\Commands\MakeQueryBuilder;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeQueryBuilder::class,
            ]);
        }
        $this->publishes([
            __DIR__ . '/../config/laravel-query-builder.php' => config_path('laravel-query-builder.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/laravel-query-builder.php', 'laravel-query-builder'
        );
    }
}
