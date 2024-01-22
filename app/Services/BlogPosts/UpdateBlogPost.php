<?php

namespace App\Services\BlogPosts;

use App\Models\BlogPost;
use App\Services\BlogPostImages\RegisterBlogPostImage;
use App\Services\BlogPostImages\UpdateBlogPostImage;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateBlogPost
{
    private RegisterBlogPostImage $registerBlogPostImage;
    private UpdateBlogPostImage $updateBlogPostImage;

    public function __construct(RegisterBlogPostImage $registerBlogPostImage, UpdateBlogPostImage $updateBlogPostImage)
    {
        $this->registerBlogPostImage = $registerBlogPostImage;
        $this->updateBlogPostImage = $updateBlogPostImage;
    }

    public function update(array $data, int $blogPostId): BlogPost|string
    {
        DB::beginTransaction();

        try {
            $blogPost = BlogPost::findOrFail($blogPostId);

            $categories = data_get($data, 'categories');
            throw_if(empty($categories), Exception::class, 'Categories are required');
            $blogPost->categories()->sync($categories);

            $blogPost->fill($data);
            $blogPost->save();

            $currentBlogPostImage = $blogPost->userImage;

            $newBlogPostImage = data_get($data, 'image');
            $newBlogPostImageId = data_get($newBlogPostImage, 'id');
            $newBlogPostImageFile = data_get($newBlogPostImage, 'file');

            if ($newBlogPostImageFile && !$newBlogPostImageId) {
                if ($currentBlogPostImage) {
                    $this->updateBlogPostImage->update($data, $currentBlogPostImage->id, $blogPost);
                } else {
                    $this->registerBlogPostImage->register($data, $blogPost);
                }
            }

            DB::commit();

            return $blogPost;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
