<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    function create($class, $attributes = [], $times = null)
    {
        return factory($class, $times)->create($attributes);
    }
}
