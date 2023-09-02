<?php

namespace App\Repository\Contracts;

use App\Dtos\Tag\CreateTagDto;
use App\Dtos\Tag\UpdateTagDto;
use App\Models\Tag;

interface TagRepositoryContract
{
    function create(CreateTagDto $createTagDto): Tag;

    function get(int $id): Tag|null;

    function update(UpdateTagDto $updateTagDto): Tag;
    
    function delete(int $id): bool;
}
