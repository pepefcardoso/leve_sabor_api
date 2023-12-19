<?php

namespace App\Services\UserImages;

use App\Models\UserImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateUserImage
{
    public function update(array $data, int $id, int $userId)
    {
        DB::beginTransaction();

        try {
            $userImage = UserImage::findOrFail($id);
            Storage::disk('s3')->delete($userImage->path);

            $imageExtension = $data['image']->extension();

            $imageName = $userId . '.' . $imageExtension;

            $path = Storage::disk('s3')->put('users_images', $data['image']);
            $path = Storage::disk('s3')->url($path);

            $userImage->fill([
                'user_id' => $userId,
                'path' => $path,
                'name' => $imageName,
            ]);
            $userImage->save();

            DB::commit();

            return $userImage;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
