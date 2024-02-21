<?php

namespace Tests\Feature\Controller\Posts;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PublicTest extends TestCase
{
    use RefreshDatabase;

    public function testAllUsersCanSeeListOfPosts(): void
    {
        $user=User::factory()->create();
        $posts=Post::factory()->count(2)->create();
        Sanctum::actingAs($user);

        $response = $this->get(route('posts.Public.list'));
        $response->assertStatus(200);

        dd($response->json());

        // $response->assertJson([
        //     'data' => [
        //         ['title' => $posts[0]->title],
        //         ['title' => $posts[1]->title]
        //     ]
        // ]);
        // $response->assertJsonPath('title', $posts->first()->title);

    }

    public function testFilterPostByTitle(): void
    {
        $user=User::factory()->create();
        Sanctum::actingAs($user);

        // dummy
        Post::factory()->count(2)->create();
        $title = fake()->name();
        $targetPost = Post::factory()->create(['title'=>  $title]);
        Post::factory()->count(2)->create();

        $response = $this->get(route('posts.Public.list', ['search'=> $title]));
        $response->assertStatus(200);
        $response->assertJsonPath('data.0.id', $targetPost->id)
        ->assertJson(fn (AssertableJson $json) =>
            $json->has('data', 1)->etc()
        );

    }

    public function testAllUsersCanSeeEachOfThePosts(): void
    {
        $post=Post::factory()->hasComments(rand(1,3))->hasLikes(rand(1,10))->create();
        // dd( $post);
        $user=User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->get(route('posts.Public.show', $post->id));
        $response->assertStatus(200);
        // $response->assertJsonPath('message','Show Post Successful');
        $response->assertJson([
            'data' => [
                'id' => $post->id,
                // 'title' => $post->title,
                'body' => $post->body,
                'picture' => $post->picture,
                'Number_of_likes' => $post->Number_of_likes,
                'Number_of_comments' => $post->Number_of_comments,
            ],
        ]);

    }

    public function testAllUsersCanCreateCommentForEachOfThePosts(): void
    {
        $post=Post::factory()->create();
        $user=User::factory()->create();
        $comment=Comment::factory()->for($user)->for($post)->create();
        // $comment=Comment::factory()->state([
        //     'user_id'=>$user->id,
        //     'post_id'=>$post->id,
        // ])->make();
        Sanctum::actingAs($user);
        $response =$this->post(route('posts.Public.comment',$post->id),[
            'user_id'=>  $comment['user_id'],
            'post_id'=>  $comment['post_id'],
            'content'=>  $comment['content']
        ]);
        $response->assertStatus(201);
        $response->assertJsonPath('message','Create Comment Successful');
                // ->assertOk();
    }

    public function testAllUsersCanLikesForEachOfThePosts(): void
    {
        $post=Post::factory()->create();
        $user=User::factory()->create();
        $like=Like::factory()->for($user)->for($post)->create();
        // $like=Like::factory()->state([
        //     'user_id'=>$user->id,
        //     'post_id'=>$post->id,
        // ])->make();
        Sanctum::actingAs($user);
        $response =$this->post(route('posts.Public.like',$post->id),[
            'user_id'=>  $like['user_id'],
            'post_id'=>  $like['post_id']
        ]);
        $response->assertStatus(201);
        $response->assertJsonPath('message','This post was liked');
                // ->assertOk();
    }
}
