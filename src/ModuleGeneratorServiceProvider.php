<?php

namespace Willywes\ModuleGenerator;

use Illuminate\Support\ServiceProvider;

class ModuleGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
//        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'willywes');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'willywes');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/modulegenerator.php', 'modulegenerator');

        // Register the service the package provides.
        $this->app->singleton('modulegenerator', function ($app) {
            return new ModuleGenerator;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['modulegenerator'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/modulegenerator.php' => config_path('modulegenerator.php'),
        ], 'modulegenerator.config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/willywes'),
        ], 'modulegenerator.views');

        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'migrations');

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/willywes'),
        ], 'modulegenerator.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/willywes'),
        ], 'modulegenerator.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
