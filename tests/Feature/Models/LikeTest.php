<?php

namespace Tests\Feature\Models;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikeTest extends TestCase
{


    use RefreshDatabase,ModelHelperTesting;

    protected function model(): Model
    {
        return new Like();
    }

    // public function testInsertDataToLikesTable(): void
    // {
    // $like = Like::factory()->make()->toArray();
    // Like::create($like);
    // $this->assertDatabaseHas('likes', $like);
    // }

    public function testLikeRelationshipWithUser(): void
    {
        $like=Like::factory()
            ->for(User::factory())
            ->create();
        $this->assertTrue(isset($like->user->id));
        $this->assertTrue($like->user instanceof User);
    }


    public function testLikeRelationshipWithPost(): void
    {
        $like=Like::factory()
            ->for(Post::factory())
            ->create();
        $this->assertTrue(isset($like->post->id));
        $this->assertTrue($like->post instanceof Post);
    }
}
