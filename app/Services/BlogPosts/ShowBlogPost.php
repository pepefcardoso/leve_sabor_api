<?php

namespace App\Services\BlogPosts;

use App\Models\BlogPost;

class ShowBlogPost
{
    public function show(int $id)
    {
        $blogPost = BlogPost::findOrFail($id);

        return $blogPost->load('user', 'blogPostImage'); //->append('temporary_url_blog_post_image');
    }
}
