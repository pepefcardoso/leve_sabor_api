<?php

namespace App\Services\BlogPostCategories;

use App\Models\BlogPostCategory;

class ShowBlogPostCategory
{
    public function show(int $id)
    {
        $blogPostCategory = BlogPostCategory::findOrFail($id);

        return $blogPostCategory;
    }
}
