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

            if ($category->business()->exists()) {
                throw new \Exception("Cannot delete this diet. It is associated with one or more businesses.");
            }

            $category->delete();

            DB::commit();

            return $category;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
