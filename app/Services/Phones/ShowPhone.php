<?php

namespace App\Services\Phones;

use App\Models\Phone;

class ShowPhone
{
    public function show($request)
    {
        $phone = Phone::findOrFail($request->id);

        return $phone;
    }
}
