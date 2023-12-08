<?php

namespace App\Services\Phones;

use \App\Models\Phone;
class UpdatePhone {
    public function update($request)
    {
        $phone = Phone::findOrFail($request->id);

        $phone->fill($request->all());
        $phone->save();

        return $phone;
    }
}
