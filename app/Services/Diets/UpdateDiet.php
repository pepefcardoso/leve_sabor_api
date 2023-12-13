<?php

namespace App\Services\Diets;

use App\Models\Diet;
use Illuminate\Support\Facades\DB;


class UpdateDiet
{
    public function update(array $data,int $id)
    {
        DB::beginTransaction();

        try {
            $diet = Diet::findOrFail($id);

            $diet->fill($data);
            $diet->save();

            DB::commit();

            return $diet;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
