<?php

namespace App\Dtos\Post;

class CreatePostDto 
{
    public string $name;
    public string $body;
    public string $imageUrl;
    public int|null $categoryId;
    public array|null $tagsIds;
}