<?php

namespace App\Services\BlogPostImages;

use App\Models\BlogPostImage;

class ShowBlogPostImage
{
    public function show(int $id)
    {
        return BlogPostImage::findOrfail($id);
    }
}
