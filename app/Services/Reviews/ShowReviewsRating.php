<?php

namespace App\Services\Reviews;

use App\Models\Review;

class ShowReviewsRating
{
    public function getRating(int $businessId)
    {
        $reviews = Review::where('business_id', $businessId)->get();

        $totalRating = 0;
        $totalReviews = $reviews->count();

        foreach ($reviews as $review) {
            $totalRating += $review->rating;
        }

        $averageRating = $totalReviews > 0 ? $totalRating / $totalReviews : 0;

        return [
            'total_reviews' => $totalReviews,
            'average_rating' => $averageRating,
        ];
    }
}
