<?php

namespace App\Services\UserImages;

use App\Models\UserImage;
use App\Services\Phones\DeletePhone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateUserImage
{
    public function __construct(DeletePhone $deletePhone)
    {
        $this->deletePhone = $deletePhone;
    }

    public function update(array $data, int $id, int $userId)
    {
        DB::beginTransaction();

        try {
            $userImage = UserImage::findOrFail($id);

            $this->deletePhone->delete($id);

            $image = data_get($data, 'image');

            $imageName = $userId . '.' . $image->extension();

            $path = Storage::disk('s3')->putFileAs('users_images', $image, $imageName);

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
