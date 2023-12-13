<?php

namespace App\Services\CookingStyle;

use App\Models\CookingStyle;
use Illuminate\Support\Facades\DB;

class UpdateCookingStyle
{
    public function update(array $data,int $id)
    {
        DB::beginTransaction();

        try {
            $cookingStyle = CookingStyle::findOrFail($id);

            $cookingStyle->fill($data);
            $cookingStyle->save();

            DB::commit();

            return $cookingStyle;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
