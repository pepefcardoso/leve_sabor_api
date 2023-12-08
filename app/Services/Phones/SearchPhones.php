<?php

namespace App\Services\Phones;

use App\Models\Phone;

class SearchPhones
{
    public function search($request, $filters)
    {
        $phones = Phone::where('contact_id', $filters['contactId'])
            ->get();

        return $phones;
    }
}