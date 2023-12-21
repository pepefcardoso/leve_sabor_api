<?php

namespace App\Services\OpeningHours;

use App\Models\OpeningHours;

class SearchOpeningHours
{
    public function search(array $filters)
    {
        $openingHours = OpeningHours::where('business_id', $filters['businessId'])
            ->get();

        return $openingHours;
    }
}
