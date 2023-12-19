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
            $image = $data['image'];

            $imageName = $userId . '.' . $image->extension();

            $path = Storage::disk('s3')->putFileAs('user_images', $image, $imageName);
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
