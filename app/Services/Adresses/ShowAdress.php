<?php

namespace App\Services\Adresses;

use App\Models\Adress;

class ShowAdress
{
    public function show(int $id)
    {
        $adress = Adress::findOrFail($id);

        return $adress;
    }
}
