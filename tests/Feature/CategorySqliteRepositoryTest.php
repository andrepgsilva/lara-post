<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use App\Dtos\Category\CreateCategoryDto;
use App\Dtos\Category\UpdateCategoryDto;
use App\Repository\CategorySqliteRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategorySqliteRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_category(): void
    {
        $categorySqliteRepository = new CategorySqliteRepository();
        $createCategoryDto = new CreateCategoryDto();

        $createCategoryDto->name = 'new category';
        
        $category = $categorySqliteRepository->create($createCategoryDto);

        $this->assertInstanceOf(Category::class, $category);
    }

    public function test_it_can_get_a_category(): void
    {
        $categorySqliteRepository = new CategorySqliteRepository();
        $createCategoryDto = new CreateCategoryDto();

        $createCategoryDto->name = 'new category';
        
        $newCategory = $categorySqliteRepository->create($createCategoryDto);

        $category = $categorySqliteRepository->get($newCategory->id);

        $this->assertInstanceOf(Category::class, $category);
    }

    public function test_it_can_get_update_a_category(): void 
    {
        $categorySqliteRepository = new CategorySqliteRepository();
        $createCategoryDto = new CreateCategoryDto();
        $updateCategoryDto = new UpdateCategoryDto();

        $createCategoryDto->name = 'new category';
        
        $newCategory = $categorySqliteRepository->create($createCategoryDto);

        $updateCategoryDto->id = $newCategory->id;
        $updateCategoryDto->name = 'Completely updated';

        $category = $categorySqliteRepository->update($updateCategoryDto);

        $this->assertTrue($category->name === 'Completely updated');
    }

    public function test_it_can_get_delete_a_category(): void 
    {
        $categorySqliteRepository = new CategorySqliteRepository();
        $createCategoryDto = new CreateCategoryDto();

        $createCategoryDto->name = 'new category';
        
        $newCategory = $categorySqliteRepository->create($createCategoryDto);

        $result = $categorySqliteRepository->delete($newCategory->id);

        $this->assertTrue($result);
    }
}
