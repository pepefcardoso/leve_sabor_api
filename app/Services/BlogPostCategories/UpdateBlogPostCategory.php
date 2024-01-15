<?php

namespace App\Services\BlogPostCategories;

use App\Models\BlogPostCategory;
use Illuminate\Support\Facades\DB;

class UpdateBlogPostCategory
{
    public function update(array $data, int $id)
    {
        DB::beginTransaction();

        try {
            $blogPostCategory = BlogPostCategory::findOrFail($id);

            $blogPostCategory->fill($data);
            $blogPostCategory->save();

            DB::commit();

            return $blogPostCategory;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
