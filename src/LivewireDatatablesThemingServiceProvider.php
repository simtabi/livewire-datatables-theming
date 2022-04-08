<?php

namespace Simtabi\LivewireDatatablesTheming;

use Illuminate\Support\ServiceProvider as Provider;

final class LivewireDatatablesThemingServiceProvider extends Provider
{

    private string $packageName = 'livewire-datatables-theming';
    private const  PACKAGE_PATH = __DIR__.'/../';

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->loadTranslationsFrom(self::PACKAGE_PATH . "resources/lang/", $this->packageName);
        $this->loadMigrationsFrom(self::PACKAGE_PATH.'/../database/migrations');
        $this->loadViewsFrom(self::PACKAGE_PATH . "resources/views", $this->packageName);
        $this->mergeConfigFrom(self::PACKAGE_PATH . "config/{$this->packageName}.php", $this->packageName);

        $this->app->make('config')->set([
            'livewire-tables.theme' => 'bootstrap-5',
        ]);
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
       $this->registerConsoles();
    }

    private function registerConsoles(): static
    {
        if ($this->app->runningInConsole())
        {

            $this->publishes([
                self::PACKAGE_PATH . "config/{$this->packageName}.php"  => config_path("{$this->packageName}.php"),
            ], "{$this->packageName}:config");

            $this->publishes([
                self::PACKAGE_PATH . "public"                           => public_path("vendor/{$this->packageName}"),
            ], "{$this->packageName}:assets");

            $this->publishes([
                self::PACKAGE_PATH . "resources/views"                  => resource_path("views/vendor/{$this->packageName}"),
            ], "{$this->packageName}:all-views");

            $this->publishes([
                self::PACKAGE_PATH . "resources/views/medicone-systems" => resource_path("views/vendor/{$this->packageName}"),
            ], "{$this->packageName}:medicone-systems-views");

            $this->publishes([
                self::PACKAGE_PATH . "resources/views"                  => resource_path("views/vendor/{$this->packageName}"),
            ], "{$this->packageName}:rappasoft-views");

            $this->publishes([
                self::PACKAGE_PATH . "resources/lang"                   => $this->app->langPath("vendor/{$this->packageName}"),
            ], "{$this->packageName}:translations");
        }

        return $this;
    }

}
