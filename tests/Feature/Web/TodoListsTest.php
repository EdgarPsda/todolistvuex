<?php

namespace Tests\Feature\Web;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoListsTest extends TestCase
{
    /** @test */
    public function testCanVisitIndex()
    {
        $response = $this->get(route('todolist.index'));
        $response->assertOk();
    }
    
}
