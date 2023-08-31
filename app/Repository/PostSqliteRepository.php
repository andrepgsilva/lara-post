<?php

namespace App\Repository;

use App\Models\Post;
use App\Models\Category;
use App\Dtos\Post\CreatePostDto;
use App\Dtos\Post\UpdatePostDto;
use App\Repository\Contracts\PostRepository;

class PostSqliteRepository implements PostRepository
{
    function create(CreatePostDto $createPostDto): Post 
    {
        $name = $createPostDto->name;
        $body = $createPostDto->body;
        $imageUrl = $createPostDto->imageUrl;
        $categoryId = $createPostDto->categoryId;
        $tagsIds = $createPostDto->tagsIds;

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

        return $post;
    }

    function get(int $id): Post|null 
    {
        $post = Post::with(['category', 'tags'])->find($id);

        return $post;
    }

    function update(UpdatePostDto $updatePostDto): Post
    {
        $id = $updatePostDto->id;
        $name = $updatePostDto->name;
        $body = $updatePostDto->body;
        $imageUrl = $updatePostDto->imageUrl;
        $categoryId = $updatePostDto->categoryId;
        $tagsIds = $updatePostDto->tagsIds;

        $post = Post::find($id);
        $category = Category::find($categoryId);
        
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

        return $post;
    }

    function delete(int $id): bool 
    {
        $post = Post::find($id);

        $post->tags()->sync([]);
        
        return $post->delete();
    }
}