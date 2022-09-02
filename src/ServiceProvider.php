<?php

namespace Daguilarm\ActionForms;

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
        $this->bootDirectives();
        $this->bootBladeComponents();

        if ($this->app->runningInConsole()) {
            $this->bootPublishAssets();
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/action-forms.php', 'action-forms');
    }

    /**
     * Boot the package resources
     */
    private function bootResources(): void
    {
        //Load the views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'action-forms');
    }

    /**
     * Boot the package blade components
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

    /**
     * Boot the package blade directives
     */
    private function bootDirectives(): void
    {
        Blade::directive('ActionForms', function (string $expression) {
            return "<?php echo '<script defer src=\"". config('action-forms.cdn.javascript.alpinejs')."\"></script><script src=\"https://cdn.tailwindcss.com\"></script>'; ?>";
        });

        Blade::directive('ActionFormsAlpine', function (string $expression) {
            return "<?php echo '<script defer src=\"". config('action-forms.cdn.javascript.alpinejs')."\"></script>'; ?>";
        });

        Blade::directive('ActionFormsTailwind', function (string $expression) {
            return "<?php echo '<script src=\"https://cdn.tailwindcss.com\"></script>'; ?>";
        });
    }

    /**
     * Publish the package assets
     */
    private function bootPublishAssets(): void
    {
        $this->publishes([
            __DIR__ . '/../resources/views' => $this->app->resourcePath('views/vendor/laravel-action-forms'),
        ], 'views');
    }
}
