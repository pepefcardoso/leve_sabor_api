<?php

namespace App\Services\CookingStyle;

use App\Models\CookingStyle;
use Illuminate\Support\Facades\DB;

class DeleteCookingStyle
{
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $cookingStyle = CookingStyle::findOrFail($id);

            $cookingStyle->delete();

            DB::commit();

            return $cookingStyle;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }


    }
}
