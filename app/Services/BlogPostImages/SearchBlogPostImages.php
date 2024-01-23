<?php

namespace App\Services\BlogPostImages;

use App\Models\BlogPostImage;

class SearchBlogPostImages
{
    public function search($filters)
    {
        $blogPostId = data_get($filters, 'blogPostId');

        return BlogPostImage::where('blog_post_id', $blogPostId)
            ->get();
    }
}
