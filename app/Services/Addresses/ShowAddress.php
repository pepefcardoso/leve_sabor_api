<?php

namespace App\Services\Addresses;

use App\Models\Address;

class ShowAddress
{
    public function show(int $id)
    {
        $address = Address::findOrFail($id);

        return $address;
    }
}
