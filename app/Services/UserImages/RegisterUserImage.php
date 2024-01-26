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
            $file = data_get($data, 'file');

            throw_if(!$file, new Exception('File not found'));

            $name = $userId . '.' . $file->extension();

            $path = Storage::disk('s3')->putFileAs(UserImage::$S3Directory, $file, $name);

            $userImage = UserImage::create([
                    'user_id' => $userId,
                    'path' => $path,
                    'name' => $name,
                ]
            );

            DB::commit();

            return $userImage;
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
