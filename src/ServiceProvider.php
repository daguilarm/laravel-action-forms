<?php

namespace Daguilarm\Forms;

use Illuminate\Support\ServiceProvider as PackageProvider;

final class ServiceProvider extends PackageProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //Resources 
        $this->registerResources();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        // 
    }

    /**
     * Register the package resources
     *
     * @return void
     */
    private function registerResources(): void
    {
        //Load the views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'belich');
    }
}