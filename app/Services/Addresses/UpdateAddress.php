<?php

namespace App\Services\Addresses;

use App\Models\Address;
use Illuminate\Support\Facades\DB;

class UpdateAddress
{
    public function update(array $data, int $id)
    {
        DB::beginTransaction();

        try {
            $address = Address::findOrFail($id);

            $address->fill($data);
            $address->save();

            DB::commit();

            return $address;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
