<?php

namespace App\Services\Diets;

use App\Models\Diet;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeleteDiet
{
    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $diet = Diet::findOrFail($id);

            throw_if(
                $diet->business()->exists(),
                Exception::class,
                "Cannot delete this diet. It is associated with one or more businesses."
            );

            $diet->delete();

            DB::commit();

            return $diet;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        } catch (Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
