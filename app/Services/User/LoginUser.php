<?php

namespace App\Services\User;

class LoginUser
{
    public function login(array $data)
    {
        if (auth()->attempt($data)) {
            $user = auth()->user();
            if ($user) {
                $userRole = $user->role;
                if ($userRole) {
                    $user->scope = $userRole;
                }

                $token = $user->createToken('Access token', [$user->scope->name])->accessToken;
                return ['token' => $token];
            }
        } else {
            return ['error' => 'Password or email is incorrect'];
        }

        return ['error' => 'Login failed due to an unknown error'];
    }
}


