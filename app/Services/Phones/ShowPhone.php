<?php

namespace App\Services\Phones;

use App\Models\Phone;

class ShowPhone
{
    public function show($phoneId)
    {
        $phone = Phone::findOrfail($phoneId);

        return $phone;
    }
}
