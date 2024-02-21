<?php

namespace Tests\Feature\Middlewares;

use App\Http\Middleware\EnsureUserIsAdmin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class EnsureUserIsAdminTest extends TestCase
{
    use RefreshDatabase;
    public function testWhenUserIsNotAdmin(): void
    {
    //   $user=User::factory()->state(['role'=>'user'])->create();
    //   $user=User::factory()->count(2)->state(new Sequence(
    //     ['role'=>'user'],
    //     ['role'=>'admin']
    //   ))->create()->toArray();

    // Use user Method in UserFactory Instead state
        // $user=User::factory()->user()->create()->toArray();

        // $this->actingAs($user)
        //     ->get(route('posts.Public.list', $user->id))
        //     ->assertOk();
        // $request=Request::create('/admin','Get');
        // $middleware=new EnsureUserIsAdmin();

    // function(){}=$next in EnsureUserIsAdmin
        // $response=$middleware->handle($request,function(){});

        // $next = function () {
        //     return response('Admin Content');
        // };
        // $response=$middleware->handle($request,$next);
        // $this->assertEquals(403, $response->getStatusCode());
        // $this->assertEquals($response->getStatusCode(),302);
    }
}
