<?php

namespace App\Services\User;

use App\Models\User;

class ShowFavoriteBusiness
{
    public function show(int $userId)
    {
        $user = User::findOrFail($userId);

        $favoriteBusinesses = $user->favoriteBusinesses()->get();

        return response()->json($favoriteBusinesses);
    }
}
