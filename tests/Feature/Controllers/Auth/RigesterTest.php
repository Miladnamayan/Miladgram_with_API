<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RigesterTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    const HTTP_ROUTE = 'register';

    public function testUserRigesterSuccessfully(): void
    {
        $password = '12345678';
        $user = User::factory()->create([
            'password'=> $password
        ]);


        $response = $this->post(route(self::HTTP_ROUTE,[
            'name'=> $user->name,
            'email'=> $user->email,
            'password'=>$password,
            'confirm_password'=> $password,
            'role'=> $user->role,
            'image'=> $user->image,
        ]));



        $response->assertStatus(200);
        // $response->assertJson(fn (AssertableJson $json) =>
        //     $json->has('user')
        //         ->has('token')
        // );
        // $response->assertJsonPath('user.id', $user->id);
    }


    public function testRegisterShouldThrowAnErrorIfEmailIsMissing(): void
    {



        $this->post(route(self::HTTP_ROUTE,[
            // 'email'=>'m@gamil.com',
            'password'=>'12345678',
            'confirm password'=>'12345678',
            'name'=>'aliiiii',
            'role'=>'user',
            // 'image'=>$image,


        ]))
        // ->assertStatus(201);
        ->assertJsonStructure(['errors'=>['email']]);
    }
}
