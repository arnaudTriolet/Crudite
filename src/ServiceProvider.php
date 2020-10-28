<?php
namespace ArnaudTriolet\Crudite;
use Illuminate\Support\ServiceProvider as SupportServiceProvider;

class ServiceProvider extends SupportServiceProvider {
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'crudite');
    }
}