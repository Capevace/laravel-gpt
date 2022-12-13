<?php

namespace Capevace\GPT;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class GPTServiceProvider extends PackageServiceProvider
{
    // /**
    //  * Register any application services.
    //  *
    //  * @return void
    //  */
    // public function register()
    // {
    //     //
    // }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function packageBooted()
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
            ->name('gpt')
            ->hasConfigFile();
        // ->hasCommand(LaravelGptCommand::class);
    }
}
