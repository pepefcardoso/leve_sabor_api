<?php

namespace App\Services\Phones;

use App\Models\Phone;

class UpdatePhone
{
    public function update($request, $id)
    {
        $phone = Phone::findOrFail($id);

        $phone->fill($request);
        $phone->save();

        return $phone;
    }
}
