<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\UserImages\DeleteUserImage;
use App\Services\UserImages\RegisterUserImage;
use App\Services\UserImages\UpdateUserImage;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateUser
{
    private RegisterUserImage $registerUserImage;
    private UpdateUserImage $updateUserImage;
    private DeleteUserImage $deleteUserImage;

    public function __construct(RegisterUserImage $registerUserImage, UpdateUserImage $updateUserImage, DeleteUserImage $deleteUserImage)
    {
        $this->registerUserImage = $registerUserImage;
        $this->updateUserImage = $updateUserImage;
        $this->deleteUserImage = $deleteUserImage;
    }

    public function update(array $data, int $userId): User|string
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($userId);

            $user->fill($data);
            $user->save();

            $currentUserImage = $user->userImage;

            $newUserImage = data_get($data, 'image');
            $newUserImageId = data_get($newUserImage, 'id');
            $newUserImageFile = data_get($newUserImage, 'file');

            if ($currentUserImage && !$newUserImage) {
                $this->deleteUserImage->delete($currentUserImage->id);
            } elseif ($newUserImageFile && !$newUserImageId) {
                if ($currentUserImage) {
                    $this->updateUserImage->update($data, $currentUserImage->id, $userId);
                } else {
                    $this->registerUserImage->register($data, $userId);
                }
            } elseif (!$newUserImageFile && !$newUserImageId) {
                if ($currentUserImage) {
                    $this->deleteUserImage->delete($currentUserImage->id);
                }
            }

            DB::commit();

            return $user;
        } catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
