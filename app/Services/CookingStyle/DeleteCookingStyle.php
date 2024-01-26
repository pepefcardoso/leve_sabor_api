<?php

namespace App\Services\CookingStyle;

use App\Models\CookingStyle;
use Exception;
use Illuminate\Support\Facades\DB;

class DeleteCookingStyle
{
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $cookingStyle = CookingStyle::findOrFail($id);

            throw_if(
                $cookingStyle->business()->exists(),
                Exception::class,
                "Cannot delete this diet. It is associated with one or more businesses."
            );

            $cookingStyle->delete();

            DB::commit();

            return $cookingStyle;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
