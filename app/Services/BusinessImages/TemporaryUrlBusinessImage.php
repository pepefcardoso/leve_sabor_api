<?php

namespace App\Services\BusinessImages;

use App\Models\BusinessImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class TemporaryUrlBusinessImage
{
    public function temporaryUrl(BusinessImage $businessImage)
    {
        $url = Storage::disk('s3')->temporaryUrl(
            $businessImage->path, Carbon::now()->addMinutes(5)
        );

        return $url;
    }
}
