<?php

namespace App\Services\BlogPosts;

use App\Models\BlogPost;
use App\Services\BlogPostImages\DeleteBlogPostImage;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeleteBlogPost
{
    private DeleteBlogPostImage $deleteBlogPostImage;

    public function __construct(DeleteBlogPostImage $deleteBlogPostImage)
    {
        $this->deleteBlogPostImage = $deleteBlogPostImage;
    }

    public function delete(int $id): BlogPost|string
    {
        DB::beginTransaction();

        try {
            $blogPost = BlogPost::findOrFail($id);

            $blogPostImage = $blogPost->blogPostImage;

            if ($blogPostImage) {
                $response = $this->deleteBlogPostImage->delete($blogPostImage->id);
                throw_if(is_string($response), Exception::class, $response);
            }

            $blogPost->delete();

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
