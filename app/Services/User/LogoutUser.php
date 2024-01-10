<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Auth;

class LogoutUser
{
    public function logout()
    {
        $user = Auth::user();

        if ($user) {
            // Revoke the token
            $user->token()->revoke();

            return response()->json(['message' => 'User logged out successfully'], 200);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }
}

