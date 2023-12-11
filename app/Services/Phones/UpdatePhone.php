<?php

namespace App\Services\Phones;

use App\Models\Phone;

class UpdatePhone
{
    public function update($request, $contactId, $phoneId)
    {
        $phone = Phone::where('contact_id', $contactId)
            ->where('id', $phoneId)
            ->firstOrFail();

        $phone->fill($request->all());
        $phone->save();

        return $phone;
    }
}
