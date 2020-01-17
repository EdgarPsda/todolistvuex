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
        $this->withoutExceptionHandling();
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

    /** 
     * @test
     * @throws \Throwable
     * @endpoint ['PUT', 'api/v1/todolist/{todo}']
     */
    public function testUpdateUserTodo()
    {
        $user = $this->create(User::class);
        $todo = $this->create(Todo::class, ['user_id' => $user->id]);

        $todoData = $this->make(Todo::class, ['user_id' => $user->id]);

        $response = $this->putJson(route('api.todolist.update', $todo), $todoData->toArray());
        $response->assertJson([
            'data' => [
                'id' => $todo->id,
                'description' => $todoData->description,
                'dueDate' => $todoData->due_date,
                'isDone' => $todoData->is_done
            ]
        ]);
        $this->assertDatabaseHas('todos', $todoData->toArray());
    }

    /** 
     * @test
     * @throws \Throwable
     * @endpoint ['GET', 'api/v1/todolist/{todo}']
     */
    public function testGetAUsersTodo()
    {
        $user = $this->create(User::class);
        $todo = $this->create(Todo::class, ['user_id' => $user->id]);

        $response = $this->getJson(route('api.todolist.show', $todo));
        $response->assertOk();
        $response->assertJson([
            'data' => [
                [
                    'id' => $todo->id,
                    'description' => $todo->description,
                    'dueDate' => $todo->due_date,
                    'isDone' => $todo->is_done,
                    'user' => [
                        'id' => $todo->user->id
                    ]
                ]
            ]
        ]);
    }

    /** 
     * @test
     * @throws \Throwable
     * @endpoint ['DELETE', 'api/v1/todolist/{todo}']
     */
    public function testDeleteUsersTodo()
    {
        $user = $this->create(User::class);
        $todo = $this->create(Todo::class, ['user_id' => $user->id]);

        $this->deleteJson(route('api.todolist.destroy', $todo));
        $this->assertDatabaseMissing('todos', $todo->toArray());
    }
}
