<?php

namespace App\Services\BlogPostImages;

use App\Models\BlogPostImage;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegisterBlogPostImage
{
    public function register(array $data, int $blogPostId)
    {
        DB::beginTransaction();

        try {
            $file = data_get($data, 'file');

            throw_if(!$file, new Exception('File not found'));

            $name = $blogPostId . '.' . $file->extension();

            $path = Storage::disk('s3')->putFileAs(BlogPostImage::$S3Directory, $file, $name);

            $blogPostImage = BlogPostImage::create([
                    'blog_post_id' => $blogPostId,
                    'path' => $path,
                    'name' => $name,
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
