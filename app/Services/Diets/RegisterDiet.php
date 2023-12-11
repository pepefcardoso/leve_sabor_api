<?php

namespace App\Services\Diets;

use App\Models\Diet;

class RegisterDiet
{
    public function register($request)
    {
        $diet = Diet::create($request->all());

        return $diet;
    }
}
