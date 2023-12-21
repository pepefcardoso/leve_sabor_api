<?php

namespace App\Services\Addresses;

use App\Models\Address;

class SearchAddress
{
    public function search(array $filters)
    {
        $addresses = Address::where('business_id', $filters['businessId'])
            ->get();

        return $addresses;
    }
}
