<?php

namespace App\Services\Diets;

use App\Models\Diet;
use Illuminate\Support\Facades\DB;


class UpdateDiet
{
    public function update($request, $id)
    {
        DB::beginTransaction();

        try {
            $diet = Diet::findOrFail($id);

            $diet->fill($request->all());
            $diet->save();

            DB::commit();

            return $diet;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
