<?php

namespace Tests\Feature\Controller\Posts;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AuthorTest extends TestCase
{

    use RefreshDatabase, WithFaker;


    public function testAllowCreatePostToAuthor(): void
    {
        // $admin=User::factory()->state(['role'=>'author'])->create();
        // $author=User::factory()->author()->create();
        //  یه باگی اینجا هست وقتی وضعیت استاتوس عوض میشه رول عوض نمیشه
        $author=User::factory()->state(['status'=> 1])->create();
        Sanctum::actingAs($author);

        $category = Category::factory()->create();
        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $data = [
            'title'=> $this->faker()->name,
            'body'=> $this->faker()->text,
            'category_id'=> $category->id,
            'picture'=> $file
        ];

        $response = $this->postJson(route('posts.Author.create'), $data);

        $response->assertStatus(201);
        Storage::disk('public')->assertExists($response['data']['picture']);
    }



    public function testDontAllowCreatePostToAuthor(): void
    {
        $otherUsers=User::factory()->state(['status'=> 0])->create();
        Sanctum::actingAs($otherUsers);
        $response = $this->postJson(route('posts.Author.Create'));
        // $response->assertStatus(401);
        $response->assertStatus(403);
    }

    public function testDeleteAPostCreatedByTheAuthorHimself(): void
    {
        $author=User::factory()->state(['status'=> 1])->create();
        $post=Post::factory()->for($author)->create();
        Sanctum::actingAs($author);
        $response = $this->deleteJson(route('posts.Author.delete',$post->id));
        $response->assertStatus(200);
    }
}
