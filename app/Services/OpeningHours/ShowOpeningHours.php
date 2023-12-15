<?php

namespace App\Services\OpeningHours;

use App\Models\OpeningHours;

class ShowOpeningHours
{
    public function show($id)
    {
        $openingHours = OpeningHours::findOrFail($id);

        return $openingHours;
    }
}
