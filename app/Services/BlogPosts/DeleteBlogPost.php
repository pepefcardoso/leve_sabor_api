<?php

namespace App\Services\BlogPosts;

use App\Models\BlogPost;
use App\Services\BlogPostImages\DeleteBlogPostImage;
use Illuminate\Support\Facades\DB;

class DeleteBlogPost
{
    public function __construct(DeleteBlogPostImage $deleteBlogPostImage)
    {
        $this->deleteBlogPostImage = $deleteBlogPostImage;
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $blogPost = BlogPost::findOrFail($id);

            $blogPostImage = $blogPost->blogPostImage;

            if ($blogPostImage) {
                $this->deleteBlogPostImage->delete($blogPostImage->id);
            }

            $blogPost->delete();

            DB::commit();

            return $blogPost;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
