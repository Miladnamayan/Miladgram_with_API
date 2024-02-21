<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    const HTTP_ROUTE = 'login';
    /**
     * A basic feature test example.
     */
    public function testUserLoginSuccessfully(): void
    {
        $password = '12345678';
        $user = User::factory()->create([
            'password'=> $password
        ]);

        $response = $this->post(route(self::HTTP_ROUTE), [
            'email'=> $user->email,
            'password'=>$password,
            'confirm_password'=> $password,
        ]);

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('user')
                ->has('token')
        );
        $response->assertJsonPath('user.id', $user->id);
    }

  
    public function testUserLoginEmailNotFound(): void
    {
        $response = $this->post(route(self::HTTP_ROUTE), [
            'email'=> $this->faker()->email(),
            'password'=> '12435678',
            'confirm_password'=> '12435678',
        ]);

        $response->assertUnauthorized();
        $response->assertJsonPath('message', 'User not found ');
    }

    public function testUserLoginWrongPassword(): void
    {

        $user = User::factory()->create();

        $password = '12345678';
        $response = $this->post(route(self::HTTP_ROUTE), [
            'email'=> $user->email,
            'password'=> $password,
            'confirm_password'=> $password,
        ]);

        $response->assertUnauthorized();
        $response->assertJsonPath('message', 'The Password is incorrect ');
    }

}
