<?php

namespace App\Services\Categories;

use App\Models\Category;

class RegisterCategory
{
    public function register($request)
    {
        $category = Category::create($request);

        return $category;
    }
}
