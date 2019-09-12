<?php

namespace Tests\Feature\Api;

use App\Todo;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class TodoListsTest extends TestCase
{
    use RefreshDatabase;

    /** 
     * @test
     * @throws \Throwable
     * @endpoint ['GET', 'api/v1/todolist/{user}']
     */
    public function testGetAllUserTodoList()
    {
        $user = $this->create(User::class);
        $todo = $this->create(Todo::class, ['user_id' => $user->id]);

        $response = $this->getJson(route('api.todolist.todosByUser', $user));
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                [
                    'id' => $todo->id,
                    'description' => $todo->description,
                    'dueDate' => $todo->due_date,
                    'isDone' => $todo->is_done,
                    'user' => [
                        'id' => $todo->user->id,
                        'name' => $todo->user->name,
                        'email' => $todo->user->email
                    ],
                ]
            ]
        ]);
    }

    /** 
     * @test
     * @throws \Throwable
     * @endpoint ['POST', 'api/v1/totolist/']
     */
    public function testStoreUserTodo()
    {
        $user = $this->create(User::class);
        $todoData = $this->make(Todo::class, ['user_id' => $user->id]);

        $response = $this->postJson(route('api.todolist.store'), $todoData->toArray());
        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'description' => $todoData->description,
                'dueDate' => $todoData->due_date,
                'isDone' => $todoData->is_done,
            ]
        ]);

        $this->assertDatabaseHas('todos', $todoData->toArray());

    }
    
}
