<?php

namespace App\Services\BlogPosts;

use App\Models\BlogPost;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class RemoveFromFavorites
{
    private ShowBlogPost $showBlogPost;

    public function __construct(ShowBlogPost $showBlogPost)
    {
        $this->showBlogPost = $showBlogPost;
    }

    public function remove(int $postId): bool|string
    {
        DB::beginTransaction();

        try {
            $userId = auth()->user()->id;

            throw_if(!$userId, Exception::class, 'User not found.');

            $user = User::findOrFail($userId);

            $user->favoriteBlogPosts()->detach($postId);

            DB::commit();

            return $user->favoriteBlogPosts()->where('blog_post_id', $postId)->exists();
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        } catch (Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
