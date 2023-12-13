<?php

namespace App\Services\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class RegisterCategory
{
    public function register(array $data)
    {
        DB::beginTransaction();

        try {
            $category = Category::create($data);

            DB::commit();

            return $category;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
