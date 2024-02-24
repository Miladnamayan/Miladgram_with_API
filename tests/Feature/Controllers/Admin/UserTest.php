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


    private $user;
    private $users;
    private $admin;
    private $author;
    private $nonAdminRoles;
    private $nonAuthorRoles;



    public function setUp():void
    {
        parent::setUp();
        $this->user = User::factory()->create(['name'=>'MILAD']);
        $this->users = User::factory()->count(2)->create();
        $this->admin = User::factory()->admin()->create(['name'=>'ADMIN']);
        $this->author = User::factory()->author()->create(['name'=>'AUTHOR']);
        $this->nonAdminRoles =User::factory()->state(['role'=> Arr::random(['user', 'author'])])->create();
        $this->nonAuthorRoles =User::factory()->state(['role'=> Arr::random(['user', 'admin'])])->create();
    }


    public function testShowListOfAllUsersForAdmin(): void
    {
        Sanctum::actingAs($this->admin);
        $response = $this->getJson(route('admin.list'));
        $this->assertEquals('MILAD',$response->json()[0]['name']);
        $this->assertEquals('admin',$response->json()[3]['role']);
        $this->assertEquals(5,count( $response->json()));
        $response
        ->assertStatus(200)
        ->assertJsonStructure([
            '*' =>[
            'id',
            'email',
            'name',
            'role'
        ]]);
    }

    public function testDontShowListOfUsersForNonAdminRoles(): void
    {
        Sanctum::actingAs($this->nonAdminRoles);
        $response = $this->getJson(route('admin.list'));
        $response->assertStatus(403);
    }

    public function testShowAUserForAdmin(): void
    {
        Sanctum::actingAs($this->admin);
        $response = $this->getJson(route('admin.show',$this->user))
            ->assertStatus(200)
            ->assertOk()
            ->json();
        $this->assertEquals($response['name'],$this->user->name);
    }

    public function testDontShowAUsersForNonAdminRoles(): void
    {
        Sanctum::actingAs($this->nonAdminRoles);
        $response = $this->getJson(route('admin.show',$this->user));
        $response->assertStatus(403);
    }

    public function testDeleteUserForAdmin(): void
    {
        Sanctum::actingAs($this->admin);
        $response = $this->deleteJson(route('admin.delete',$this->user->id));
        $response->assertStatus(200);
        $this->assertDatabaseMissing($this->user->getTable(), [
            'id' => $this->user->id,
        ]);
    }

    public function testNotAllowingDeletionUserForNonAdminRoless(): void
    {
        Sanctum::actingAs($this->nonAdminRoles);
        $response = $this->deleteJson(route('admin.delete',$this->user->id));
        $response->assertStatus(403);
        $this->assertDatabaseHas($this->user->getTable(), [
            'id' => $this->user->id,
        ]);
    }

    public function testAcceptUserForAdmin(): void
    {
        Sanctum::actingAs($this->admin);
        $response = $this->deleteJson(route('admin.delete',$this->user->id));
        $response->assertStatus(200);
        $this->assertDatabaseMissing($this->user->getTable(), [
            'id' => $this->user->id,
        ]);
    }

}
