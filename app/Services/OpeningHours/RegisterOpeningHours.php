<?php

namespace App\Services\OpeningHours;

use App\Models\OpeningHours;
use Illuminate\Support\Facades\DB;

class RegisterOpeningHours
{
    public function register(array $data)
    {
        DB::beginTransaction();

        try {
            $openingHours = OpeningHours::create($data);

            DB::commit();

            return $openingHours;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
