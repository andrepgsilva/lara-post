<?php

namespace App\Repository\Contracts;

use App\Dtos\Tags\CreateTagDto;
use App\Dtos\Tags\UpdateTagDto;
use App\Models\Tag;

interface TagRepository
{
    function create(CreateTagDto $createTagDto): Tag;
    function get(int $id): Tag|null;
    function update(UpdateTagDto $updateTagDto): Tag;
    function delete(int $id): bool;
}
