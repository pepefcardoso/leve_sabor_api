<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class RemoveFavoriteBusiness
{
    public function remove(int $userId, int $businessId)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($userId);

            $user->favoriteBusinesses()->detach($businessId);

            DB::commit();

            return response()->json(['message' => 'Business removed from favorites.']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Something went wrong.'], 500);
        }
    }
}
