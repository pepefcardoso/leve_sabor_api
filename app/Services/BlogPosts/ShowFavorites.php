<?php

namespace App\Services\BlogPosts;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

class ShowFavorites
{
    public function index(): string|JsonResponse
    {
        try {
            $userId = auth()->user()->id;

            throw_if(!$userId, Exception::class, 'User not found.');

            $user = User::findOrFail($userId);

            $favoriteBlogPosts = $user->favoriteBlogPosts()->get();

            return response()->json($favoriteBlogPosts);
        } catch (Exception $e) {
            return $e->getMessage();
        } catch (Throwable $e) {
            return $e->getMessage();
        }
    }
}
