<?php

namespace App\Services\BusinessImages;

use App\Models\BusinessImage;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;

class TemporaryUrlBusinessImage
{
    public function temporaryUrl(BusinessImage $businessImage): ?string
    {
        try {
            $url = Storage::disk('s3')->temporaryUrl(
                $businessImage->path, Carbon::now()->addMinutes(5)
            );
        } catch (Exception) {
            return null;
        }

        return $url;
    }
}
