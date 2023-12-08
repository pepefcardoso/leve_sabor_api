<?php

namespace App\Services\Phones;

use App\Models\Phone;

class DeletePhone
{
    public function delete($request)
    {
        $phone = Phone::findOrFail($request->id);

        $phone->delete();

        return $phone;
    }
}
