<?php

namespace App\Repository\Contracts;

use App\Models\Post;
use App\Dtos\Post\CreatePostDto;
use App\Dtos\Post\UpdatePostDto;

interface PostRepository 
{
    function create(CreatePostDto $createPostDto): Post;
    function get(int $id): Post|null;
    function update(UpdatePostDto $updatePostDto): Post;
    function delete(int $id): bool;
}