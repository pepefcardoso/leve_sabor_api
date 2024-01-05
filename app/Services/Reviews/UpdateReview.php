<?php

namespace App\Services\Reviews;

use App\Models\Review;
use Illuminate\Support\Facades\DB;

class UpdateReview
{
    public function update(array $data, int $id)
    {
        DB::beginTransaction();

        try {
            $review = Review::findOrFail($id);

            $review->fill($data);
            $review->save();

            DB::commit();

            return $review;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
