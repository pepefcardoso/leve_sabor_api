<?php

namespace App\Services\BlogPostCategories;

use App\Models\BlogPostCategory;

class SearchBlogPostCategories
{
    public function search()
    {
        $blogPostCategories = BlogPostCategory::all();

        return $blogPostCategories;
    }
}
