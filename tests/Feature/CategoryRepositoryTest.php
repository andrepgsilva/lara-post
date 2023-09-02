<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use App\Dtos\Category\CreateCategoryDto;
use App\Dtos\Category\UpdateCategoryDto;
use App\Repository\CategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_category(): void
    {
        $categoryRepository = new CategoryRepository();
        $createCategoryDto = new CreateCategoryDto();

        $createCategoryDto->name = 'new category';
        
        $category = $categoryRepository->create($createCategoryDto);

        $this->assertInstanceOf(Category::class, $category);
    }

    public function test_it_can_get_a_category(): void
    {
        $categoryRepository = new CategoryRepository();
        $createCategoryDto = new CreateCategoryDto();

        $createCategoryDto->name = 'new category';
        
        $newCategory = $categoryRepository->create($createCategoryDto);

        $category = $categoryRepository->get($newCategory->id);

        $this->assertInstanceOf(Category::class, $category);
    }

    public function test_it_can_get_update_a_category(): void 
    {
        $categoryRepository = new CategoryRepository();
        $createCategoryDto = new CreateCategoryDto();
        $updateCategoryDto = new UpdateCategoryDto();

        $createCategoryDto->name = 'new category';
        
        $newCategory = $categoryRepository->create($createCategoryDto);

        $updateCategoryDto->id = $newCategory->id;
        $updateCategoryDto->name = 'Completely updated';

        $category = $categoryRepository->update($updateCategoryDto);

        $this->assertTrue($category->name === 'Completely updated');
    }

    public function test_it_can_get_delete_a_category(): void 
    {
        $categoryRepository = new CategoryRepository();
        $createCategoryDto = new CreateCategoryDto();

        $createCategoryDto->name = 'new category';
        
        $newCategory = $categoryRepository->create($createCategoryDto);

        $result = $categoryRepository->delete($newCategory->id);

        $this->assertTrue($result);
    }
}
