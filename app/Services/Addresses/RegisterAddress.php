<?php

namespace App\Services\Addresses;

use App\Models\Address;
use Illuminate\Support\Facades\DB;

class RegisterAddress
{
    public function register(array $data, int $businessId)
    {
        DB::beginTransaction();

        try {
            $data['business_id'] = $businessId;

            $address = Address::create($data);

            DB::commit();

            return $address;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
