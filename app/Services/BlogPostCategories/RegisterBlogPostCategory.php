<?php

namespace App\Services\BlogPostCategories;

use App\Models\BlogPostCategory;
use Illuminate\Support\Facades\DB;

class RegisterBlogPostCategory
{
    public function register(array $data)
    {
        DB::beginTransaction();

        try {
            $blogPostCategory = BlogPostCategory::create($data);

            DB::commit();

            return $blogPostCategory;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
