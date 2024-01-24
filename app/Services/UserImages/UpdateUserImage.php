<?php

namespace App\Services\UserImages;

use App\Models\UserImage;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateUserImage
{
    public function update(array $data, int $id, int $userId): UserImage|string
    {
        DB::beginTransaction();

        try {
            $userImage = UserImage::findOrFail($id);

            $newFile = data_get($data, 'file');

            throw_if(!$newFile, new Exception('File not found'));

            $newName = $userId . '.' . $newFile->extension();

            $path = Storage::disk('s3')->putFileAs(UserImage::$S3Directory, $newFile, $newName);

            if ($path && $userImage->name !== $newName) {
                Storage::disk('s3')->delete(UserImage::$S3Directory . '/' . $userImage->name);
            } else {
                throw new Exception('Error uploading image.');
            }

            $userImage->fill([
                'user_id' => $userId,
                'path' => $path,
                'name' => $newName,
            ]);

            $userImage->save();

            DB::commit();

            return $userImage;
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
