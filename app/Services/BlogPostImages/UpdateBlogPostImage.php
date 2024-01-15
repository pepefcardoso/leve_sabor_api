<?php

namespace App\Services\BlogPostImages;

use App\Models\BlogPostImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateBlogPostImage
{
    public function update(array $data, int $id, int $blogPostId)
    {
        DB::beginTransaction();

        try {
            $blogPostImage = BlogPostImage::findOrFail($id);

            $image = data_get($data, 'image');

            $imageName = $blogPostId . '.' . $image->extension();

            $path = Storage::disk('s3')->putFileAs('blog_posts_images', $image, $imageName);

            $blogPostImage->fill([
                'blog_post_id' => $blogPostId,
                'path' => $path,
                'name' => $imageName,
            ]);
            $blogPostImage->save();

            DB::commit();

            return $blogPostImage;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
