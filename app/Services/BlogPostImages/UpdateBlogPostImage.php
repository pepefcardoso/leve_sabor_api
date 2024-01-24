<?php

namespace App\Services\BlogPostImages;

use App\Models\BlogPostImage;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateBlogPostImage
{
    public function update(array $data, int $id, int $blogPostId): BlogPostImage|string
    {
        DB::beginTransaction();

        try {
            $blogPostImage = BlogPostImage::findOrFail($id);

            $newFile = data_get($data, 'file');

            throw_if(!$newFile, new Exception('File not found'));

            $newName = $blogPostId . '.' . $newFile->extension();

            $path = Storage::disk('s3')->putFileAs(BlogPostImage::$S3Directory, $newFile, $newName);

            if ($path && $blogPostImage->name !== $newName) {
                Storage::disk('s3')->delete(BlogPostImage::$S3Directory . '/' . $blogPostImage->name);
            } else {
                throw new Exception('Error uploading image.');
            }

            $blogPostImage->fill([
                'blog_post_id' => $blogPostId,
                'path' => $path,
                'name' => $newName,
            ]);

            $blogPostImage->save();

            DB::commit();

            return $blogPostImage;
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
