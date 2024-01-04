<?php

namespace App\Services\BusinessImages;

use App\Models\BusinessImage;

class SearchBusinessImage
{
    public function search(array $filters)
    {
        $businessImages = BusinessImage::where('business_id', $filters['businessId'])
            ->get();

        return $businessImages;
    }
}
