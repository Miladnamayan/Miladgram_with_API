<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{



    use RefreshDatabase,WithFaker,ModelHelperTesting;

    protected function model(): Model
    {
        return new User();
    }



    public function testInsertDataToUsersTable(): void
    {
    // User::factory()->create();
      $data=User::factory()->make()->toArray();
    //   $data['password']=12345678;
      $data['password']= Hash::make('12345678');
    // $password=12345678;
    //   $data['password']= $password;
    $missingdata=User::factory()->make()->toArray();
    User::create($data);
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', $data);
        $this->assertDatabaseMissing('users',$missingdata );
    }

    public function testUserRelationshipWithPost(): void
    {
        $count=rand(1,10);
        $user=User::factory()
            // ->has(Post::factory()->count($count))
            ->hasPosts($count)
            ->create();
        $this->assertCount($count,$user->posts);
        $this->assertTrue($user->posts->first() instanceof Post);
    }

    public function testUserRelationshipWithComment(): void
    {
        $count=rand(1,10);
        $user=User::factory()
            // ->has(Comment::factory()->count($count))
            ->hasComments($count)
            ->create();
        $this->assertCount($count,$user->comments);
        $this->assertTrue($user->comments->first() instanceof Comment);
    }

    public function testUserRelationshipWithLike(): void
    {
        $count=rand(1,10);
        $user=User::factory()
            // ->has(Like::factory()->count($count))
            ->hasLikes($count)
            ->create();
        $this->assertCount($count,$user->likes);
        $this->assertTrue($user->likes->first() instanceof Like);
    }
}
