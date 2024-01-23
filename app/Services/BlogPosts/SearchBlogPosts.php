<?php

namespace App\Services\BlogPosts;

use App\Models\BlogPost;

class SearchBlogPosts
{
    public function search()
    {
        return BlogPost::with('user', 'blogPostImage')->get();
    }
}
