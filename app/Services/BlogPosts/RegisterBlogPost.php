<?php

namespace App\Services\BlogPosts;

use App\Models\BlogPost;
use App\Services\BlogPostImages\RegisterBlogPostImage;
use Exception;
use Illuminate\Support\Facades\DB;

class RegisterBlogPost
{
    private RegisterBlogPostImage $registerBlogPostImage;

    public function __construct(RegisterBlogPostImage $registerBlogPostImage)
    {
        $this->registerBlogPostImage = $registerBlogPostImage;
    }

    public function register(array $data): BlogPost|string
    {
        DB::beginTransaction();

        try {

            $userId = auth()->user()->id;

            throw_if(empty($userId), Exception::class, 'User is required');

            $data['user_id'] = $userId;

            $blogPost = BlogPost::create($data);

            $categories = data_get($data, 'categories');

            throw_if(empty($categories), Exception::class, 'Categories is required');

            $blogPost->categories()->attach($categories);

            $imageData = data_get($data, 'image');

            if ($imageData) {
                $response = $this->registerBlogPostImage->register($imageData, $blogPost->id);
                throw_if(is_string($response), Exception::class, $response);
            }

            DB::commit();

            return $blogPost;
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
