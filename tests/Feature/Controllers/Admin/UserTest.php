<?php

namespace Tests\Feature\Controller\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Support\Arr;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function testShowListOfUsersForAdmin(): void
    {
        // $admin=User::factory()->state(['role'=>'admin'])->create();
        // $admin=User::factory()->admin()->create()->role;
        $admin=User::factory()->admin()->create();
        // $users=User::factory()->count(2)->create();
        $users=User::factory()->create();

        Sanctum::actingAs($admin);
        $response = $this->getJson(route('admin.list'));


        // dd($users->count());
        // dd(User::all());
        $response
        ->assertStatus(200)
        ->assertJsonIsArray()
        // ->assertJsonCount(3)
        ->assertJsonFragment(['role' => 'admin'])
        ->assertJson([ $admin->toArray()])
        ->assertJsonStructure([
            '*' => [
                'id',
                'email',
                'name',
                'role'
            ]
        ]);
    }

    public function testDontShowListOfUsersForOtherUsers(): void
    {
        $otherUsers=User::factory()->state(['role'=> Arr::random(['user', 'author'])])->create();
        // $users=User::factory()->count(5)->create();
        Sanctum::actingAs($otherUsers);
        $response = $this->getJson(route('admin.list'));
        // $response->assertStatus(401);
        $response->assertStatus(403);
    }

    public function testDeleteUserForAdmin(): void
    {
        $admin=User::factory()->admin()->create();
        $user=User::factory()->create();
        Sanctum::actingAs($admin);
        $response = $this->deleteJson(route('admin.delete',$user->id));
        $response->assertStatus(200);

        $this->assertDatabaseMissing($user->getTable(), [
            'id' => $user->id,
        ]);
    }

    public function testNotAllowingDeletionUserForOtherUsers(): void
    {
        $otherUsers=User::factory()->state(['role'=> Arr::random(['user', 'author'])])->create();
        $user=User::factory()->create();
        Sanctum::actingAs($otherUsers);
        $response = $this->deleteJson(route('admin.delete',$user->id));
        $response->assertStatus(403);
        $this->assertDatabaseHas($user->getTable(), [
            'id' => $user->id,
        ]);
    }




}
