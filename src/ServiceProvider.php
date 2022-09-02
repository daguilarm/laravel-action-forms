<?php

namespace Daguilarm\Forms;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as PackageProvider;
use Illuminate\View\Compilers\BladeCompiler;

final class ServiceProvider extends PackageProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        //Resources
        $this->bootResources();
        $this->bootBladeComponents();
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Register the package resources
     */
    private function bootResources(): void
    {
        //Load the views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'action-forms');
    }

    /**
     * Register the package blade components
     */
    private function bootBladeComponents(): void
    {
        Blade::componentNamespace('Daguilarm\\ActionForms\\Components', 'action-forms');

        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) {
            $prefix = config('action-forms.prefix', '');

            foreach (config('action-forms.components', []) as $alias => $component) {
                $componentClass = is_string($component) ? $component : $component['class'];
                $blade->component($componentClass, $alias, $prefix);
            }
        });
    }
}
