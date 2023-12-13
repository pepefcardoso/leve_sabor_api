<?php

namespace App\Services\Adresses;

use App\Models\Adress;

class SearchAdress
{
    public function search()
    {
        $adresses = Adress::all();

        return $adresses;
    }
}
