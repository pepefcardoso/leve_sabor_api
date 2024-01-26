<?php

namespace App\Services\BlogPosts;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class RemoveFromFavorites
{
    public function remove(int $postId): string|JsonResponse
    {
        DB::beginTransaction();

        try {
            $userId = auth()->user()->id;

            throw_if(!$userId, Exception::class, 'User not found.');

            $user = User::findOrFail($userId);

            $user->favoriteBlogPosts()->detach($postId);

            DB::commit();

            return response()->json(['message' => 'Business removed from favorites.']);
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        } catch (Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
