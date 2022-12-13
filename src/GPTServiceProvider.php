<?php

namespace Capevace\GPT\Providers;

use Capevace\GPT\GPTService;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class GPTServiceProvider extends PackageServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(GPTService::class, function ($app) {
            return new GPTService();
        });
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-gpt');
        // ->hasConfigFile()
        // ->hasCommand(LaravelGptCommand::class);
    }
}