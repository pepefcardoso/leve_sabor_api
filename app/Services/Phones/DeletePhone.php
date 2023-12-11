<?php

namespace App\Services\Phones;

use App\Models\Phone;

class DeletePhone
{
    public function delete($request, $contactId, $phoneId)
    {
        $phone = Phone::where('contact_id', $contactId)
            ->where('id', $phoneId)
            ->firstOrFail();

        $phone->delete();

        return $phone;
    }
}
