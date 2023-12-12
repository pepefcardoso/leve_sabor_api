<?php

namespace App\Services\Categories;

use App\Models\Category;

class DeleteCategory
{
    public function delete(int $id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return $category;
    }
}
