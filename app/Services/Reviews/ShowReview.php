<?php

namespace App\Services\Reviews;

use App\Models\Review;

class ShowReview
{
    public function show($id)
    {
        $review = Review::findOrFail($id);

        return $review;
    }
}
