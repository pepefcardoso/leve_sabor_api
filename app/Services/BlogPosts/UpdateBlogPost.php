<?php

namespace App\Services\BlogPosts;

use App\Models\BlogPost;
use App\Services\BlogPostImages\RegisterBlogPostImage;
use App\Services\BlogPostImages\UpdateBlogPostImage;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

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

            $currentBlogPostImage = $blogPost->blogPostImage;

            $newImageData = data_get($data, 'image');
            $newImageId = data_get($newImageData, 'id');
            $newImageFile = data_get($newImageData, 'file');

            if ($newImageFile && !$newImageId) {
                if ($currentBlogPostImage) {
                    $response = $this->updateBlogPostImage->update($newImageData, $currentBlogPostImage->id, $blogPost->id);
                    throw_if(is_string($response), Exception::class, $response);
                } else {
                    $response = $this->registerBlogPostImage->register($newImageData, $blogPost->id);
                    throw_if(is_string($response), Exception::class, $response);
                }
            }

            DB::commit();

            return $blogPost;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        } catch (Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
