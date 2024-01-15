<?php

namespace App\Services\BlogPosts;

use App\Models\BlogPost;

class SearchBlogPosts
{
    public function search()
    {
        $blogPosts = BlogPost::with('user', 'blogPostImage')->get();

        return $blogPosts;
    }
}
