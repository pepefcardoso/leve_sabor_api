<?php

namespace App\Services\BlogPosts;

use App\Models\BlogPost;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class AddToFavorites
{
    private ShowBlogPost $showBlogPost;

    public function __construct(ShowBlogPost $showBlogPost)
    {
        $this->showBlogPost = $showBlogPost;
    }

    public function add(int $postId): BlogPost|string
    {
        DB::beginTransaction();

        try {
            $userId = auth()->user()->id;

            throw_if(!$userId, Exception::class, 'User not found.');

            $user = User::findOrFail($userId);

            $user->favoriteBlogPosts()->attach($postId);

            DB::commit();

            return $this->showBlogPost->show($postId);
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        } catch (Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
