<?php

namespace App\Services\Categories;

use App\Models\Category;

class ShowCategory
{
    public function show($id)
    {
        $category = Category::findOrFail($id);

        return $category;
    }
}
