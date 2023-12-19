<?php

namespace App\Services\UserImages;

use App\Models\UserImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteUserImage
{
    public function Delete(int $id)
    {
        DB::beginTransaction();

        try {
            $userImage = UserImage::findOrFail($id);

            $userImage->delete();

            Storage::disk('s3')->delete('user_images/' . $userImage->name);

            DB::commit();

            return $userImage;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
