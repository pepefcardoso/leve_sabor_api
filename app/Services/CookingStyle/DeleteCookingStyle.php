<?php

namespace App\Services\CookingStyle;

use App\Models\CookingStyle;

class DeleteCookingStyle
{
    public function delete(int $id)
    {
        $cookingStyle = CookingStyle::findOrFail($id);

        $cookingStyle->delete();

        return $cookingStyle;
    }
}
