<?php

namespace App\Services\Categories;

use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeleteCategory
{
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $category = Category::findOrFail($id);

            throw_if($category->business()->exists(), Exception::class, "Cannot delete this diet. It is associated with one or more businesses.");

            $category->delete();

            DB::commit();

            return $category;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        } catch (Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
