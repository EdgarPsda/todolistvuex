<?php

namespace Tests\Unit;

use App\Todo;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testTodoBelongstoUser()
    {
        $user = $this->create(User::class);
        $todo = $this->create(Todo::class, ['user_id' => $user->id]);
        $this->assertInstanceOf(User::class, $todo->user);
    }
    
}
