<?php

namespace App\Services\Reviews;

use App\Models\Review;

class SearchUserReviews
{
    public function search(array $filters)
    {
        $userId = data_get($filters, 'user_id');

        $reviews = Review::where('user_id', $userId)->get();

        return $reviews;
    }
}
