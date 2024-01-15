<?php

namespace App\Services\BlogPostImages;

use App\Models\BlogPostImage;

class SearchBlogPostImages
{
    public function search($filters)
    {
        $blogPostId = data_get($filters, 'blogPostId');

        $blogPostImages = BlogPostImage::where('blog_post_id', $blogPostId)
            ->get();

        return $blogPostImages->append('temporary_url_blog_post_image');
    }
}
