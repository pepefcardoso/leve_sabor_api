<?php

namespace App\Services\CookingStyle;

use App\Models\CookingStyle;

class RegisterCookingStyle
{
    public function register($request)
    {
        $cookingStyle = CookingStyle::create($request->all());

        return $cookingStyle;
    }
}
