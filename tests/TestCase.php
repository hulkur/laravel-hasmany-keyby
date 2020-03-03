<?php

namespace Hulkur\HasManyKeyBy\Test;

use Hulkur\HasManyKeyBy\ServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }
}
