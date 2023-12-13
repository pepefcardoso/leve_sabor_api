<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class RegisterUser
{
    public function register(array $data)
    {
        DB::beginTransaction();

        try {
            $data['password'] = bcrypt($data['password']);

            $user = User::create($data);

            $token = $user->createToken('LaravelAuthApp')->accessToken;

            DB::commit();

            return $token;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
