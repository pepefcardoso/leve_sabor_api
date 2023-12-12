<?php

namespace App\Services\Categories;

use App\Models\Category;

class SearchCategories
{
    public function search()
    {
        $categories = Category::all();

        return $categories;
    }
}
