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
                $response = $this->deleteUserImage->delete($currentUserImage->id);
                throw_if(is_string($response), Exception::class, $response);
            } elseif ($newImageFile && !$newImageId) {
                if ($currentUserImage) {
                    $response = $this->updateUserImage->update($newImageData, $currentUserImage->id, $userId);
                    throw_if(is_string($response), Exception::class, $response);
                } else {
                    $response = $this->registerUserImage->register($newImageData, $userId);
                    throw_if(is_string($response), Exception::class, $response);
                }
            } elseif (!$newImageFile && !$newImageId) {
                if ($currentUserImage) {
                    $response = $this->deleteUserImage->delete($currentUserImage->id);
                    throw_if(is_string($response), Exception::class, $response);
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
