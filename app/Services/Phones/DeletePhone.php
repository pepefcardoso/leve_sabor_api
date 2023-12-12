<?php

namespace App\Services\Phones;

use App\Models\Phone;

class DeletePhone
{
    public function delete($id)
    {
        $phone = Phone::findOrFail($id);

        $phone->delete();

        return $phone;
    }
}
