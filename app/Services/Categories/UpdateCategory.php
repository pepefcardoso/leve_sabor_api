<?php

namespace App\Services\Categories;

use App\Models\Category;

class UpdateCategory
{
    public function update($request, $id)
    {
        $category = Category::where('id', $id)
            ->firstOrFail();

        $category->fill($request->all());
        $category->save();

        return $category;
    }
}
