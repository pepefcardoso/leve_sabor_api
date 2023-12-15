<?php

namespace App\Services\OpeningHours;

use App\Models\OpeningHours;
use Illuminate\Support\Facades\DB;

Class DeleteOpeningHours
{
    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $openingHours = OpeningHours::findOrFail($id);

            $openingHours->delete();

            DB::commit();

            return $openingHours;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
