<?php

namespace App\Services\BlogPosts;

use App\Models\BlogPost;
use App\Services\BlogPostImages\DeleteBlogPostImage;
use App\Services\BlogPostImages\RegisterBlogPostImage;
use App\Services\BlogPostImages\UpdateBlogPostImage;
use Illuminate\Support\Facades\DB;

class UpdateBlogPost
{
    public function __construct(RegisterBlogPostImage $registerBlogPostImage, UpdateBlogPostImage $updateBlogPostImage, DeleteBlogPostImage $deleteBlogPostImage)
    {
        $this->registerBlogPostImage = $registerBlogPostImage;
        $this->updateBlogPostImage = $updateBlogPostImage;
        $this->deleteBlogPostImage = $deleteBlogPostImage;
    }

    public function update(array $data, int $blogPostId)
    {
        DB::beginTransaction();

        try {
            $blogPost = BlogPost::findOrFail($blogPostId);

            $categories = data_get($data, 'categories');
            throw_if(empty($categories), \Exception::class, 'Categories are required');
            $blogPost->categories()->sync($categories);

            $blogPost->fill($data);
            $blogPost->save();

            $currentBlogPostImage = $blogPost->blogPostImage;
            $newBlogPostImage = data_get($data, 'image');

            if ($currentBlogPostImage) {
                if ($newBlogPostImage) {
                    $this->updateBlogPostImage->update($newBlogPostImage, $currentBlogPostImage->id, $blogPost->id);
                } else {
                    $this->deleteBlogPostImage->delete($currentBlogPostImage->id);
                }
            } else {
                if ($newBlogPostImage) {
                    $this->registerBlogPostImage->register($newBlogPostImage, $blogPost->id);
                }
            }

            DB::commit();

            return $blogPost;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
