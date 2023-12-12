<?php

namespace App\Services\CookingStyle;

use App\Models\CookingStyle;

class UpdateCookingStyle
{
    public function update($request, $id)
    {
        $cookingStyle = CookingStyle::findOrFail($id);

        $cookingStyle->fill($request->all());
        $cookingStyle->save();

        return $cookingStyle;
    }
}
