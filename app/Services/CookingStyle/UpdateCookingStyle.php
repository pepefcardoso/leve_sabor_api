<?php

namespace App\Services\CookingStyle;

use App\Models\CookingStyle;
use Illuminate\Support\Facades\DB;

class UpdateCookingStyle
{
    public function update($request, $id)
    {
        DB::beginTransaction();

        try {
            $cookingStyle = CookingStyle::findOrFail($id);

            $cookingStyle->fill($request->all());
            $cookingStyle->save();

            DB::commit();

            return $cookingStyle;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
