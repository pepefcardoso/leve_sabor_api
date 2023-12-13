<?php

namespace App\Services\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class RegisterCategory
{
    public function register($request)
    {
        DB::beginTransaction();

        try {
            $category = Category::create($request->all());

            DB::commit();

            return $category;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
