<?php

namespace Tests;

use FreePlaceholder\FreePlaceholderServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            FreePlaceholderServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('freeplaceholder.base_url', 'https://freeplaceholder.com');
        $app['config']->set('freeplaceholder.defaults', []);
        $app['config']->set('freeplaceholder.avatar_defaults', []);
    }
}
