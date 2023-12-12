<?php

namespace App\Services\Categories;

use App\Models\Category;

class DeleteCategory
{
    public function delete(int $id)
    {
        $category = Category::where('id', $id)->firstOrFail();

        $category->delete();

        return $category;
    }
}
