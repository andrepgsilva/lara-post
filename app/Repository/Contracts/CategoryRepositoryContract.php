<?php

namespace App\Repository\Contracts;

use App\Dtos\Category\CreateCategoryDto;
use App\Dtos\Category\UpdateCategoryDto;
use App\Models\Category;

interface CategoryRepositoryContract 
{
    function create(CreateCategoryDto $createCategoryDto): Category;

    function get(int $id): Category|null;

    function update(UpdateCategoryDto $updateCategoryDto): Category;

    function delete(int $id): bool;
}