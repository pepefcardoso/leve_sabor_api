<?php

namespace App\Services\BusinessImages;

use App\Models\BusinessImage;

class ShowBusinessImage
{
    public function show(int $id)
    {
        $businessImage = BusinessImage::findOrfail($id);

        return $businessImage;
    }
}
