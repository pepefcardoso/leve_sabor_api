<?php

namespace App\Services\UserImages;

use App\Models\UserImage;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegisterUserImage
{
    public function register(array $data, int $userId)
    {
        DB::beginTransaction();

        try {
            $imageExtension = $data['image']->extension();

            $imageName = $userId . '.' . $imageExtension;

            $path = Storage::disk('s3')->put('users_images', $data['image']);
            $path = Storage::disk('s3')->url($path);

            $userImage = UserImage::create([
                    'user_id' => $userId,
                    'path' => $path,
                    'name' => $imageName,
                ]
            );

            DB::commit();

            return $userImage;
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
