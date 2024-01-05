<?php

namespace App\Services\Reviews;

use App\Models\Review;
use Illuminate\Support\Facades\DB;

class DeleteReview
{
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $review = Review::findOrFail($id);

            $review->delete();

            DB::commit();

            return $review;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
