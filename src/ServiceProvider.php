<?php

namespace Simtabi\LivewireDatatablesTheming;

use Illuminate\Support\ServiceProvider as Provider;

final class ServiceProvider extends Provider
{

    private string $namespace = 'livewire-datatables-theming';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {

        //Load the views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', $this->namespace);

        //Publish views
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/livewire/datatables'),
        ], $this->namespace);

        //Load language translations...
        $this->loadTranslationsFrom(resource_path('lang'), $this->namespace);

        //Publish translations
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/' . $this->namespace),
        ], $this->namespace);

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

}
