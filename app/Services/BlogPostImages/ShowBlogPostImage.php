<?php

namespace App\Services\BlogPostImages;

use App\Models\BlogPostImage;

class ShowBlogPostImage
{
    public function show(int $id)
    {
        $blogPostImage = BlogPostImage::findOrfail($id);

        return $blogPostImage->append('temporary_url_blog_post_image');
    }
}
