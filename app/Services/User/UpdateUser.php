<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\UserImages\DeleteUserImage;
use App\Services\UserImages\RegisterUserImage;
use App\Services\UserImages\UpdateUserImage;
use Illuminate\Support\Facades\DB;

class UpdateUser
{
    public function __construct(RegisterUserImage $registerUserImage, UpdateUserImage $updateUserImage, DeleteUserImage $deleteUserImage)
    {
        $this->registerUserImage = $registerUserImage;
        $this->updateUserImage = $updateUserImage;
        $this->deleteUserImage = $deleteUserImage;
    }

    public function update(array $data, int $userId)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($userId);

            $user->fill($data);
            $user->save();

            $currentUserImage = $user->userImage;
            $newUserImage = $data['image'] ?? null;

            if ($currentUserImage) {
                if ($newUserImage) {
                    $this->updateUserImage->update($newUserImage, $currentUserImage->id, $user->id);
                }
            } else {
                if ($newUserImage) {
                    $this->registerUserImage->register($newUserImage, $user->id);
                }
            }

            //TODO - Delete user image

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
