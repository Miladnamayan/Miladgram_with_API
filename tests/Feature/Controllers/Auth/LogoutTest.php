<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    const HTTP_ROUTE = 'logout';
    /**
     * A basic feature test example.
     */
    public function testUserLogoutSuccessfully(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->post(route(self::HTTP_ROUTE));

        $response->assertStatus(200);
        $response->assertJsonPath('message','Logged out');
    }

    public function testUserLogoutWithoutToken(): void
    {
        $user = User::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer asdasdadsdasdasdsa',
            'Accept'=> 'application/json'
            ])->post(route(self::HTTP_ROUTE));

        $response->assertStatus(401);
    }
}
