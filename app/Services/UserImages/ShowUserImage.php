<?php

namespace App\Services\UserImages;

use App\Models\UserImage;

class ShowUserImage
{
    public function show(int $id)
    {
        $userImage = UserImage::findOrfail($id);

        return $userImage;
    }
}
