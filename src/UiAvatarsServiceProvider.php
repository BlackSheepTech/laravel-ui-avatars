<?php

namespace BlackSheepTech\UiAvatars;

use Illuminate\Support\ServiceProvider;

/**
 * @internal
 */
class UiAvatarsServiceProvider extends ServiceProvider
{
    /**
     * Register any package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/ui-avatars.php', 'ui-avatars'
        );
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {

        $this->registerPublishing();
        $this->registerCommands();
    }

    /**
     * Register the package's publishable resources.
     */
    protected function registerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/ui-avatars.php' => config_path('ui-avatars.php'),
            ], ['ui-avatars', 'ui-avatars-config']);
        }
    }

    /**
     * Register the package's commands.
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);
        }
    }
}
