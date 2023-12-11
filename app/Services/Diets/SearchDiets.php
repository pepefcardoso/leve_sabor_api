<?php

namespace App\Services\Diets;

use App\Models\Diet;

class SearchDiets
{
    public function search()
    {
        $diets = Diet::all();

        return $diets;
    }
}
