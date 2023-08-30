<?php

namespace Tests\Feature;

use App\Models\Tag;
use Tests\TestCase;
use App\Dtos\Tags\CreateTagDto;
use App\Dtos\Tags\UpdateTagDto;
use App\Repository\TagSqliteRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagSqliteRepositoryTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_it_can_create_a_tag(): void
    {
        $tagSqliteRepository = new TagSqliteRepository();

        $createTagDto = new CreateTagDto();
        $createTagDto->name = 'new tag';
        $tag = $tagSqliteRepository->create($createTagDto);

        $this->assertInstanceOf(Tag::class, $tag);
    }

    public function test_it_can_get_a_tag(): void
    {
        $tagSqliteRepository = new TagSqliteRepository();

        $createTagDto = new CreateTagDto();
        $createTagDto->name = 'new tag';
        $newTag = $tagSqliteRepository->create($createTagDto);

        $tag = $tagSqliteRepository->get($newTag->id);

        $this->assertInstanceOf(Tag::class, $tag);
    }

    public function test_it_can_update_a_tag(): void
    {
        $tagSqliteRepository = new TagSqliteRepository();

        $createTagDto = new CreateTagDto();
        $createTagDto->name = 'tag';
        $newTag = $tagSqliteRepository->create($createTagDto);

        $updateTagDto = new UpdateTagDto();
        $updateTagDto->id = $newTag->id;
        $updateTagDto->name = 'new tag';

        $tagSqliteRepository->update($updateTagDto);

        $tag = $tagSqliteRepository->get($newTag->id);

        $this->assertTrue($tag->name === 'new tag');
    }

    public function test_it_can_delete_a_tag(): void
    {
        $tagSqliteRepository = new TagSqliteRepository();

        $createTagDto = new CreateTagDto();
        $createTagDto->name = 'tag';
        $newTag = $tagSqliteRepository->create($createTagDto);

        $result = $newTag->delete();

        $this->assertTrue($result);
    }
}
