<?php

namespace App\Services\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class UpdateCategory
{
    public function update(array $data,int $id)
    {
        DB::beginTransaction();

        try {
            $category = Category::findOrFail($id);

            $category->fill($data);
            $category->save();

            DB::commit();

            return $category;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
