<?php

namespace App\Repository;
use App\Models\Tag;
use App\Dtos\Tags\CreateTagDto;
use App\Dtos\Tags\UpdateTagDto;
use App\Repository\Contracts\TagRepository;

class TagSqliteRepository implements TagRepository
{
    function create(CreateTagDto $createTagDto): Tag
    {
        $name = $createTagDto->name;

        $tag = Tag::create(['name' => $name]);

        return $tag;
    }

    function get(int $id): Tag|null
    {
        $tag = Tag::find($id);

        return $tag;
    }

    function update(UpdateTagDto $updateTagDto): Tag
    {
        $id = $updateTagDto->id;
        $name = $updateTagDto->name;

        $tag = Tag::find($id);

        $tag->name = $name;
        $tag->save();

        return $tag;
    }

    public function delete(int $id): bool 
    {
        $tag = Tag::find($id);
        
        return $tag->delete();
    }
}