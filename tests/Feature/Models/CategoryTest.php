<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testCategoryRelationshipWithPost(): void
    {
        $count=rand(1,10);
        $category=Category::factory()
            // ->has(Post::factory()->count($count))
            ->hasPosts($count)
            ->create();
        $this->assertCount($count,$category->posts);
        $this->assertTrue($category->posts->first() instanceof Post);
    }
}
