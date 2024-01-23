<?php

namespace App\Services\UserImages;


use App\Models\UserImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class TemporaryUrlUserImage
{
    public function temporaryUrl(UserImage $userImage): ?string
    {
        try {
            $url = Storage::disk('s3')->temporaryUrl(
                $userImage->path, Carbon::now()->addMinutes(5)
            );
        } catch (\Exception) {
            return null;
        }

        return $url;
    }
}
