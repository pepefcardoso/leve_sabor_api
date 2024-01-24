<?php

namespace App\Services\BlogPosts;

use App\Enums\BlogPostStatusEnum;
use App\Models\BlogPost;

class GetLastBlogPost
{
    public function get()
    {
        $blogPost = BlogPost::where('status', BlogPostStatusEnum::PUBLISHED)->orderBy('created_at', 'DESC')->firstOrFail();

        return $blogPost->load('blogPostImage', 'categories');
    }
}
