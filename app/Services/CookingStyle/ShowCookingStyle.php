<?php

namespace App\Services\CookingStyle;

use App\Models\CookingStyle;

class ShowCookingStyle
{
    public function show($id)
    {
        $cookingStyle = CookingStyle::findOrFail($id);

        return $cookingStyle;
    }
}
