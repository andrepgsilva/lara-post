<?php

namespace Tests\Feature;

use App\Models\Tag;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Category;
use App\Dtos\Post\CreatePostDto;
use App\Dtos\Post\UpdatePostDto;
use App\Repository\PostSqliteRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class PostSqliteRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_post(): void
    {
        $postSqlRepositoryTest = new PostSqliteRepository();

        $createPostDto = new CreatePostDto();
        $createPostDto->name = 'new name';
        $createPostDto->body = 'body';
        $createPostDto->imageUrl = 'https://example.example.com';
        $createPostDto->categoryId = null;
        $createPostDto->tagsIds = [];

        $post = $postSqlRepositoryTest->create($createPostDto);

        $this->assertInstanceOf(Post::class, $post);
    }

    public function test_it_can_create_a_post_with_a_category(): void 
    {
        $postSqlRepositoryTest = new PostSqliteRepository();
        $category = Category::create(['name' => 'new category']);

        $createPostDto = new CreatePostDto();
        $createPostDto->name = 'new name';
        $createPostDto->body = 'body';
        $createPostDto->imageUrl = 'https://example.example.com';
        $createPostDto->categoryId = $category->id;
        $createPostDto->tagsIds = [];

        $post = $postSqlRepositoryTest->create($createPostDto);

        $this->assertInstanceOf(Post::class, $post);
        $this->assertInstanceOf(Category::class, $post->category);
    }

    public function test_it_can_create_a_post_with_tags(): void 
    {
        $postSqlRepositoryTest = new PostSqliteRepository();
        $category = Category::create(['name' => 'new category']);
        $firstTag = Tag::create(['name' => 'first tag']);
        $secondTag = Tag::create(['name' => 'second tag']);

        $createPostDto = new CreatePostDto();
        $createPostDto->name = 'new name';
        $createPostDto->body = 'body';
        $createPostDto->imageUrl = 'https://example.example.com';
        $createPostDto->categoryId = $category->id;
        $createPostDto->tagsIds = [$firstTag->id, $secondTag->id];

        $post = $postSqlRepositoryTest->create($createPostDto);

        $this->assertInstanceOf(Post::class, $post);
        $this->assertInstanceOf(Category::class, $post->category);
        $this->assertCount(2, $post->tags);
    }

    public function test_it_can_get_a_post(): void 
    {
        $postSqlRepositoryTest = new PostSqliteRepository();
        $createPostDto = new CreatePostDto();
        $category = Category::create(['name' => 'new category']);
        $createPostDto->name = 'new name';
        $createPostDto->body = 'body';
        $createPostDto->imageUrl = 'https://example.example.com';
        $createPostDto->categoryId = $category->id;
        $createPostDto->tagsIds = [];
        $post = $postSqlRepositoryTest->create($createPostDto);

        $post = $postSqlRepositoryTest->get($post->id);

        $this->assertInstanceOf(Post::class, $post);
        $this->assertInstanceOf(Category::class, $post->category);
        $this->assertTrue($post->category->name == $category->name);
    }

    public function test_it_can_update_a_post(): void 
    {
        $postSqlRepositoryTest = new PostSqliteRepository();
        $category = Category::create(['name' => 'new category']);
        $categoryTwo = Category::create(['name' => 'updated category']);
        $firstTag = Tag::create(['name' => 'first tag']);
        $secondTag = Tag::create(['name' => 'second tag']);
        $thirdTag = Tag::create(['name' => 'third tag']);

        $createPostDto = new CreatePostDto();
        $createPostDto->name = 'new name';
        $createPostDto->body = 'body';
        $createPostDto->imageUrl = 'https://example.example.com';
        $createPostDto->categoryId = $category->id;
        $createPostDto->tagsIds = [$firstTag->id, $secondTag->id];

        $post = $postSqlRepositoryTest->create($createPostDto);

        $updatePostDto = new UpdatePostDto();
        $updatePostDto->id = $post->id;
        $updatePostDto->name = 'updated name';
        $updatePostDto->body = 'updated body';
        $updatePostDto->imageUrl = 'https://updatedexample.example.com';
        $updatePostDto->categoryId = $categoryTwo->id;
        $updatePostDto->tagsIds = [$thirdTag->id];

        $post = $postSqlRepositoryTest->update($updatePostDto);

        $this->assertInstanceOf(Post::class, $post);
        $this->assertTrue($post->name === 'updated name');
        $this->assertTrue($post->category->id === $categoryTwo->id);
        $this->assertTrue($post->tags[0]->name === 'third tag');
    }

    public function test_it_can_delete_a_post(): void 
    {
        $postSqlRepositoryTest = new PostSqliteRepository();
        $createPostDto = new CreatePostDto();
        $category = Category::create(['name' => 'new category']);
        $firstTag = Tag::create(['name' => 'first tag']);
        $createPostDto->name = 'new name';
        $createPostDto->body = 'body';
        $createPostDto->imageUrl = 'https://example.example.com';
        $createPostDto->categoryId = $category->id;
        $createPostDto->tagsIds = [$firstTag->id];
        $post = $postSqlRepositoryTest->create($createPostDto);

        $result = $postSqlRepositoryTest->delete($post->id);
        $postTagsCount = count(DB::select('SELECT * FROM post_tag'));
        $post = $postSqlRepositoryTest->get($post->id);

        $this->assertTrue($result);
        $this->assertTrue($postTagsCount === 0);
        $this->assertTrue($post === null);
    }
}
