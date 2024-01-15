<?php

namespace App\Services\BlogPostImages;


use App\Models\BlogPostImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class TemporaryUrlBlogPostImage
{
    public function temporaryUrl(BlogPostImage $blogPostImage)
    {

        $url = Storage::disk('s3')->temporaryUrl(
            $blogPostImage->path, Carbon::now()->addMinutes(5)
        );

        return $url;
    }
}
