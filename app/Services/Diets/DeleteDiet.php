<?php

namespace App\Services\Diets;

use App\Models\Diet;
use Illuminate\Support\Facades\DB;

class DeleteDiet
{
    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $diet = Diet::findOrFail($id);

            $diet->delete();

            DB::commit();

            return $diet;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
