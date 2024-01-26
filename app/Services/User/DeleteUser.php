<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\UserImages\DeleteUserImage;
use Exception;
use Illuminate\Support\Facades\DB;

class DeleteUser
{
    private DeleteUserImage $deleteUserImage;

    public function __construct(DeleteUserImage $deleteUserImage)
    {
        $this->deleteUserImage = $deleteUserImage;
    }

    public function delete($id): User|string
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);

            $userImage = $user->userImage;

            if ($userImage) {
                $response = $this->deleteUserImage->delete($userImage->id);
                throw_if(is_string($response), Exception::class, $response);
            }

            $user->delete();

            DB::commit();

            return $user;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
