<?php

namespace App\Services\Adresses;

use App\Models\Adress;
use Illuminate\Support\Facades\DB;

class UpdateAdress
{
    public function update(array $data, int $id)
    {
        DB::beginTransaction();

        try {
            $adress = Adress::findOrFail($id);

            $adress->fill($data);
            $adress->save();

            DB::commit();

            return $adress;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
