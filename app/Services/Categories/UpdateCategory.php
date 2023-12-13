<?php

namespace App\Services\Categories;

use App\Models\Category;

class UpdateCategory
{
    public function update($request, $id)
    {
        $category = Category::findOrFail($id);

        $category->fill($request);
        $category->save();

        return $category;
    }
}
