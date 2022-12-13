<?php

namespace Capevace\GPT\Tests;

use Capevace\GPT\Providers\GPTServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            GPTServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-gpt_table.php.stub';
        $migration->up();
        */
    }
}
