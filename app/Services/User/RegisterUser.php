<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\UserImages\RegisterUserImage;
use Exception;
use Illuminate\Support\Facades\DB;

class RegisterUser
{
    private RegisterUserImage $registerUserImage;

    public function __construct(RegisterUserImage $registerUserImage)
    {
        $this->registerUserImage = $registerUserImage;
    }

    public function register(array $data): ?string
    {
        DB::beginTransaction();

        try {
            $data['password'] = bcrypt($data['password']);

            $data['role_id'] = 1;

            $user = User::create($data);

            $token = $user->createToken('LaravelAuthApp')->accessToken;

            $userImage = data_get($data, 'image');

            if ($userImage) {
                $this->registerUserImage->register($userImage, $user->id);
            }

            DB::commit();

            return $token;
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
