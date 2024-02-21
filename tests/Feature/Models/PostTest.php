<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PostTest extends TestCase

{

    use RefreshDatabase,ModelHelperTesting;

    protected function model(): Model
    {
        return new Post();
    }

    // public function testInsertDataToPostsTable(): void
    // {
    // $posts = Post::factory()->make()->toArray();
    // Post::create($posts);
    // $this->assertDatabaseHas('posts', $posts);
    // }



    public function testPostRelationshipWithUser(): void
    {
        $post=Post::factory()
            ->for(User::factory())
            ->create();
        $this->assertTrue(isset($post->user->id));
        $this->assertTrue($post->user instanceof User);
    }

    public function testPostRelationshipWithCtegory(): void
    {
        $post=Post::factory()
            ->for(Category::factory())
            ->create();
        $this->assertTrue(isset($post->category->id));
        $this->assertTrue($post->category instanceof Category);
    }


    public function testPostRelationshipWithComment(): void
    {
        $count=rand(1,10);
        $post=Post::factory()
            // ->has(Comment::factory()->count($count))
            ->hasComments($count)
            ->create();
        $this->assertCount($count,$post->comments);
        $this->assertTrue($post->comments->first() instanceof Comment);
    }

    public function testPostRelationshipWithLike(): void
    {
        $count=rand(1,10);
        $post=Post::factory()
            // ->has(Like::factory()->count($count))
            ->hasLikes($count)
            ->create();
        $this->assertCount($count,$post->likes);
        $this->assertTrue($post->likes->first() instanceof Like);
    }


}
