<?php

namespace App\Repository;

use App\Models\Post;
use App\Models\Category;
use App\Dtos\Post\CreatePostDto;
use App\Dtos\Post\UpdatePostDto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Exceptions\PostUpdateFailedException;
use App\Exceptions\PostCreationFailedException;
use App\Repository\Contracts\PostRepositoryContract;

/**
 * This class is responsible for interacting with the database
 * to perform CRUD operations related to the `Post` model.
 */
class PostRepository implements PostRepositoryContract
{
    /**
     * Create a new post and return the instance.
     *
     * @param  CreatePostDto $createPostDto
     * 
     * @return Post
     * @throws PostCreationFailedException
     */
    function create(CreatePostDto $createPostDto): Post
    {
        return DB::transaction(function () use ($createPostDto) {
            $name = $createPostDto->name;
            $body = $createPostDto->body;
            $imageUrl = $createPostDto->imageUrl;
            $categoryId = $createPostDto->categoryId;
            $tagsIds = $createPostDto->tagsIds;

            try {
                $post = Post::create([
                    'name' => $name,
                    'body' => $body,
                    'image_url' => $imageUrl,
                ]);
        
                if ($categoryId !== null) {
                    $category = Category::find($categoryId);
                    $post->category()->associate($category);
                    $post->save();
                }
                
                if (count($tagsIds) !== 0) {
                    $post->tags()->sync($tagsIds);
                }
        
                $post->load('tags');
            } catch(QueryException $e) {
                $errorMessage = 'Failed to create a post: ';

                Log::error($errorMessage, ['exception' => $e]);
                throw new PostCreationFailedException($errorMessage);
            }

            return $post;
        });
    }

    /**
     * Get a new post with its relationships
     *
     * @param int $id
     * 
     * @return Post|null
     **/
    function get(int $id): Post|null 
    {
        $post = Post::with(['category', 'tags'])->find($id);

        return $post;
    }

    /**
     * Update a post and return the instance.
     *
     * @param  UpdatePostDto  $updatePostDto
     * 
     * @return Post
     * @throws PostUpdateFailedException
     */
    function update(UpdatePostDto $updatePostDto): Post
    {
        return DB::transaction(function () use ($updatePostDto) {
            $id = $updatePostDto->id;
            $name = $updatePostDto->name;
            $body = $updatePostDto->body;
            $imageUrl = $updatePostDto->imageUrl;
            $categoryId = $updatePostDto->categoryId;
            $tagsIds = $updatePostDto->tagsIds;

            $post = Post::find($id);
            $category = Category::find($categoryId);
            
            try {
                $post->update([
                    'name' => $name,
                    'body' => $body,
                    'image_url' => $imageUrl,
                ]);

                if ($categoryId !== null) {
                    $post->category()->associate($category);
                    $post->save();
                }

                if (count($tagsIds) !== 0) {
                    $post->tags()->sync($tagsIds);
                }

                $post->load('tags');
            } catch(QueryException $e) {
                $errorMessage = 'Failed to update a post.';
                
                Log::error($errorMessage, ['exception' => $e]);
                throw new PostUpdateFailedException($errorMessage);
            }

            return $post;
        });
    }

    /**
     * Delete a post and its relationships
     *
     * @param int $id
     * 
     * @return Post|null
     **/
    function delete(int $id): bool 
    {
        $post = Post::find($id);

        $post->tags()->sync([]);

        $wasThePostDeleted = $post->delete();
        
        return $wasThePostDeleted;
    }
}