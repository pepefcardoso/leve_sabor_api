<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\UserImages\RegisterUserImage;
use Illuminate\Support\Facades\DB;

class RegisterUser
{
    public function __construct(RegisterUserImage $registerUserImage)
    {
        $this->registerUserImage = $registerUserImage;
    }
    public function register(array $data)
    {
        DB::beginTransaction();

        try {
            $data['password'] = bcrypt($data['password']);

            $data['role_id'] = 1;

            $user = User::create($data);

            $token = $user->createToken('LaravelAuthApp')->accessToken;

            $userImage = $data['image'] ?? null;

            if ($userImage) {
                $this->registerUserImage->register($userImage, $user->id);
            }

            DB::commit();

            return $token;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
