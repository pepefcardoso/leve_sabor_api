<?php

namespace App\Services\User;

class LoginUser
{

    public function login(array $data)
    {
        if (auth()->attempt($data)) {

            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;

            return $token;
        } else {
            return null;
        }
    }
}
