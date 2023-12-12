<?php

namespace App\Services\CookingStyle;

use App\Models\CookingStyle;

class SearchCookingStyles
{
    public function search()
    {
        $cookingStyles = CookingStyle::all();

        return $cookingStyles;
    }
}
