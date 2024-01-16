<?php

namespace App\Services\BlogPosts;

use App\Models\BlogPost;
use App\Services\BlogPostImages\RegisterBlogPostImage;
use Illuminate\Support\Facades\DB;

class RegisterBlogPost
{
    public function __construct(RegisterBlogPostImage $registerBlogPostImage)
    {
        $this->registerBlogPostImage = $registerBlogPostImage;
    }

    public function register(array $data)
    {
        DB::beginTransaction();

        try {

            $userId = auth()->user()->id;

            throw_if(empty($userId), \Exception::class, 'User is required');

            $data['user_id'] = $userId;

            $blogPost = BlogPost::create($data);

            $categories = data_get($data, 'categories');

            throw_if(empty($categories), \Exception::class, 'Categories is required');

            $blogPost->categories()->attach($categories);

            $blogPostImage = data_get($data, 'image');

            if ($blogPostImage) {
                $this->registerBlogPostImage->register($blogPostImage, $blogPost->id);
            }

            DB::commit();

            return $blogPost;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
