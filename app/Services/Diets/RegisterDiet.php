<?php

namespace App\Services\Diets;

use App\Models\Diet;
use Illuminate\Support\Facades\DB;

class RegisterDiet
{
    public function register(array $data)
    {
        DB::beginTransaction();

        try {
            $diet = Diet::create($data);

            DB::commit();

            return $diet;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
