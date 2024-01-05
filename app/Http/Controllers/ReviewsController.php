<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Services\Reviews\DeleteReview;
use App\Services\Reviews\RegisterReview;
use App\Services\Reviews\SearchReviews;
use App\Services\Reviews\ShowReview;
use App\Services\Reviews\ShowReviewsRating;
use App\Services\Reviews\UpdateReview;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function index(SearchReviews $searchReviews, int $businessId)
    {
        $filters = ['businessId' => $businessId];

        $reviews = $searchReviews->search($filters);

        return response()->json($reviews);
    }

    public function store(Request $request, RegisterReview $registerReview, int $userId, int $businessId)
    {
        $data = $request->validate(Review::rules());

        $review = $registerReview->register($data, $userId, $businessId);

        return response()->json($review);
    }

    public function show(ShowReview $showReview, int $id)
    {
        $review = $showReview->show($id);

        return response()->json($review);
    }

    public function update(Request $request, UpdateReview $updateReview, int $id)
    {
        $data = $request->validate(Review::rules());

        $review = $updateReview->update($data, $id);

        return response()->json($review);
    }

    public function destroy(DeleteReview $deleteReview, int $id)
    {
        $review = $deleteReview->delete($id);

        return response()->json($review);
    }

    public function ratings(ShowReviewsRating $showReviewsRating, int $businessId)
    {
        $ratingInfo = $showReviewsRating->getRating($businessId);

        return response()->json($ratingInfo);
    }
}
