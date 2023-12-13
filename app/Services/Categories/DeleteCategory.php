<?php

namespace App\Services\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DeleteCategory
{
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $category = Category::findOrFail($id);

            $category->delete();

            DB::commit();

            return $category;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
