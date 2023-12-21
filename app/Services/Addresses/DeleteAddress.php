<?php

namespace App\Services\Addresses;

use App\Models\Address;
use Illuminate\Support\Facades\DB;

class DeleteAddress
{
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $address = Address::findOrFail($id);

            $address->delete();

            DB::commit();

            return $address;
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }
}
