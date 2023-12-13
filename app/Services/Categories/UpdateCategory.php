<?php

namespace App\Services\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class UpdateCategory
{
    public function update($request, $id)
    {
        DB::beginTransaction();

        try {
            $category = Category::findOrFail($id);

            $category->fill($request->all());
            $category->save();

            DB::commit();

            return $category;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
