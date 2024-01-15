<?php

namespace App\Services\BlogPostCategories;

use App\Models\BlogPostCategory;
use Illuminate\Support\Facades\DB;

class DeleteBlogPostCategory
{
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $blogPostCategory = BlogPostCategory::findOrFail($id);

            $blogPostCategory->delete();

            DB::commit();

            return $blogPostCategory;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
