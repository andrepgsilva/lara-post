<?php

namespace Tests\Feature;

use App\Models\Tag;
use Tests\TestCase;
use App\Dtos\Tag\CreateTagDto;
use App\Dtos\Tag\UpdateTagDto;
use App\Repository\TagRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagRepositoryTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_it_can_create_a_tag(): void
    {
        $tagRepository = new TagRepository();

        $createTagDto = new CreateTagDto();
        $createTagDto->name = 'new tag';
        $tag = $tagRepository->create($createTagDto);

        $this->assertInstanceOf(Tag::class, $tag);
    }

    public function test_it_can_get_a_tag(): void
    {
        $tagRepository = new TagRepository();

        $createTagDto = new CreateTagDto();
        $createTagDto->name = 'new tag';
        $newTag = $tagRepository->create($createTagDto);

        $tag = $tagRepository->get($newTag->id);

        $this->assertInstanceOf(Tag::class, $tag);
    }

    public function test_it_can_update_a_tag(): void
    {
        $tagRepository = new TagRepository();

        $createTagDto = new CreateTagDto();
        $createTagDto->name = 'tag';
        $newTag = $tagRepository->create($createTagDto);

        $updateTagDto = new UpdateTagDto();
        $updateTagDto->id = $newTag->id;
        $updateTagDto->name = 'new tag';

        $tagRepository->update($updateTagDto);

        $tag = $tagRepository->get($newTag->id);

        $this->assertTrue($tag->name === 'new tag');
    }

    public function test_it_can_delete_a_tag(): void
    {
        $tagRepository = new TagRepository();

        $createTagDto = new CreateTagDto();
        $createTagDto->name = 'tag';
        $newTag = $tagRepository->create($createTagDto);

        $result = $newTag->delete();

        $this->assertTrue($result);
    }
}
