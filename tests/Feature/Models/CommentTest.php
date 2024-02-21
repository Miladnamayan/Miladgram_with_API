<?php

namespace Tests\Feature\Models;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{

    use RefreshDatabase,ModelHelperTesting;

    protected function model(): Model
    {
        return new Comment();
    }


    // public function testInsertDataToCommentsTable(): void
    // {
    //     $comment = Comment::factory()->make()->toArray();
    //     Comment::create($comment);
    //     $this->assertDatabaseHas('comments', $comment);
    // }


    public function testCommentRelationshipWithUser(): void
    {
        $comment=Comment::factory()
            ->for(User::factory())
            ->create();
        $this->assertTrue(isset($comment->user->id));
        $this->assertTrue($comment->user instanceof User);
    }


    public function testCommentRelationshipWithPost(): void
    {
        $comment=Comment::factory()
            ->for(Post::factory())
            ->create();
        $this->assertTrue(isset($comment->post->id));
        $this->assertTrue($comment->post instanceof Post);
    }
}
