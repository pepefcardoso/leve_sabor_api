<?php

namespace App\Services\OpeningHours;

use App\Models\OpeningHours;
use Illuminate\Support\Facades\DB;

class UpdateOpeningHours
{
    public function update(array $data,int $id)
    {
        DB::beginTransaction();

        try {
            $openingHours = OpeningHours::findOrFail($id);

            $openingHours->fill($data);
            $openingHours->save();

            DB::commit();

            return $openingHours;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
