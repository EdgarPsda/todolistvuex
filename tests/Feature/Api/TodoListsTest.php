<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoListsTest extends TestCase
{
    use RefreshDatabase;

    /** 
     * @test
     * @throws \Throwable
     * @endpoint ['GET', 'api/v1/todolist']
     */
    public function testGetAllTodoList()
    {
        $this->withoutExceptionHandling();

        $todo = $this->create(Todo::class);

        $response = $this->getJson(route('api.v1.todolist.index'));
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $todo->id,
                'description' => $todo->description,
                'dueDate' => $todo->due_date,
                'user' => [
                    'id' => $todo->user->id,
                    'name' => $todo->user->name
                ],
            ]
        ]);
    }
    
}
