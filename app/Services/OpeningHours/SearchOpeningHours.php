<?php

namespace App\Services\OpeningHours;

use App\Models\OpeningHours;

class SearchOpeningHours
{
    public function search()
    {
        $openingHours = OpeningHours::all();

        return $openingHours;
    }
}
