<?php

namespace App\Services\Reviews;

use App\Models\Review;
use Illuminate\Support\Facades\DB;

class RegisterReview
{
    public function register(array $data, int $userId, int $businessId)
    {
        DB::beginTransaction();

        try {
            $data['user_id'] = $userId;

            $data['business_id'] = $businessId;

            $review = Review::create($data);

            DB::commit();

            return $review;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
