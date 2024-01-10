<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class AddFavoriteBusiness
{
    public function add(int $userId, int $businessId)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($userId);

            $user->favoriteBusinesses()->attach($businessId);

            DB::commit();

            return response()->json(['message' => 'Business added to favorites.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Something went wrong.'], 500);
        }
    }
}
