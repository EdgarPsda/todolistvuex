<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    function create($class, $attributes = [], $times = null)
    {
        return factory($class, $times)->create($attributes);
    }

    function make($class, $attributes = [], $times = null)
    {
        return factory($class, $times)->make($attributes);
    }

    public function signIn($attributes = [])
    {
        return $this->actingAs($this->create(User::class, $attributes));
    }
}
