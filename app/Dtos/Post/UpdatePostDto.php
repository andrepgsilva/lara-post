<?php

namespace App\Dtos\Post;

class UpdatePostDto 
{
    public int $id;
    public string $name;
    public string $body;
    public string $imageUrl;
    public int $categoryId;
    public array $tagsIds;
}