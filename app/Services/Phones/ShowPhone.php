<?php

namespace App\Services\Phones;

use App\Models\Phone;

class ShowPhone
{
    public function show($contactId, $phoneId)
    {
        $phone = Phone::where('contact_id', $contactId)
            ->where('id', $phoneId)
            ->firstOrFail();

        return $phone;
    }
}
