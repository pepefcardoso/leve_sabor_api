<?php

namespace App\Services\UserImages;

use App\Models\UserImage;

class SearchUserImage
{
    public function search($filters)
    {
        $userImages = UserImage::where('user_id', $filters['userId'])
            ->get();

        return $userImages;
    }
}
