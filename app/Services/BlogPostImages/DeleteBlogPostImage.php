<?php

namespace App\Services\BlogPostImages;

use App\Models\BlogPostImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DeleteBlogPostImage
{
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $blogPostImage = BlogPostImage::findOrFail($id);

            $blogPostImage->delete();

            Storage::disk('s3')->delete(BlogPostImage::$S3Directory . '/' . $blogPostImage->name);

            DB::commit();

            return $blogPostImage;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
