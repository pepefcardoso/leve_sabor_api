<?php

namespace App\Services\Adresses;

use App\Models\Adress;
use Illuminate\Support\Facades\DB;

class DeleteAdress
{
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $adress = Adress::findOrFail($id);

            $adress->delete();

            DB::commit();

            return $adress;
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }
}
