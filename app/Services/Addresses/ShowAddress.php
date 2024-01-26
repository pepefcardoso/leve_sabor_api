<?php

namespace App\Services\Addresses;

use App\Models\Address;

class ShowAddress
{
    public function show(int $id): ?Address
    {
        return Address::findOrFail($id);
    }
}
