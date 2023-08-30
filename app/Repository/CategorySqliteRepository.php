<?php

namespace App\Repository;
use App\Models\Category;
use App\Dtos\Category\CreateCategoryDto;
use App\Dtos\Category\UpdateCategoryDto;
use App\Repository\Contracts\CategoryRepository;

class CategorySqliteRepository implements CategoryRepository
{
    public function create(CreateCategoryDto $createCategoryDto): Category 
    {
        $name = $createCategoryDto->name;

        return Category::create(['name' => $name]);
    }

    function get(int $id): Category|null 
    {
        return Category::find($id);
    }

    function update(UpdateCategoryDto $updateCategoryDto): Category
    {
        $name = $updateCategoryDto->name;

        $category = Category::find($updateCategoryDto->id);
        $category->name = $name;
        $category->save();

        return $category;
    }

    function delete(int $id): bool 
    {
        $category = Category::find($id);
        
        return $category->delete();
    }
}
