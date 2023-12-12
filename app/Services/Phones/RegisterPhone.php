<?php

namespace App\Services\Phones;

use App\Models\Phone;

class RegisterPhone
{
    public function register($request, $contactId)
    {
        $request['contact_id'] = $contactId;

        $phone = Phone::create($request->all());

        return $phone;
    }
}
