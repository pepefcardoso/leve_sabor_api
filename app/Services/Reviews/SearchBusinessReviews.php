<?php

namespace App\Services\Reviews;

use App\Models\Review;

class SearchBusinessReviews
{
    public function search(array $filters)
    {
        $businessId = data_get($filters, 'businessId');

        $reviews = Review::where('business_id', $businessId)->get();

        return $reviews;
    }
}
