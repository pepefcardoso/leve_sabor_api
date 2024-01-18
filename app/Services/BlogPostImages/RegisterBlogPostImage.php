<?php

namespace App\Services\BlogPostImages;

use App\Models\BlogPostImage;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Storage;

class RegisterBlogPostImage
{
    public function register($image, int $blogPostId)
    {
        DB::beginTransaction();

        try {
            $imageName = $blogPostId . '.' . $image->extension();

            $path = Storage::disk('s3')->putFileAs('blog_posts_images', $image, $imageName);

            $blogPostImage = BlogPostImage::create([
                    'blog_post_id' => $blogPostId,
                    'path' => $path,
                    'name' => $imageName,
                ]
            );

            DB::commit();

            return $blogPostImage;
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}