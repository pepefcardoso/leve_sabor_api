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

            $newImageData = data_get($data, 'image');
            $newImageId = data_get($newImageData, 'id');
            $newImageFile = data_get($newImageData, 'file');

            if ($currentUserImage && !$newImageData) {
                $this->deleteUserImage->delete($currentUserImage->id);
            } elseif ($newImageFile && !$newImageId) {
                if ($currentUserImage) {
                    $this->updateUserImage->update($newImageData, $currentUserImage->id, $userId);
                } else {
                    $this->registerUserImage->register($newImageData, $userId);
                }
            } elseif (!$newImageFile && !$newImageId) {
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
