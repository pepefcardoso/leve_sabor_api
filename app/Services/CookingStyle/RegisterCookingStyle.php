<?php

namespace App\Services\CookingStyle;

use App\Models\CookingStyle;
use Illuminate\Support\Facades\DB;

class RegisterCookingStyle
{
    public function register($request)
    {
        DB::beginTransaction();

        try {
            $cookingStyle = CookingStyle::create($request->all());

            DB::commit();

            return $cookingStyle;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
