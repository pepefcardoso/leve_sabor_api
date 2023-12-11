<?php

namespace App\Services\Diets;

use App\Models\Diet;


class UpdateDiet
{
    public function update($request, $id)
    {
        $diet = Diet::where('id', $id)
            ->firstOrFail();

        $diet->fill($request->all());
        $diet->save();

        return $diet;
    }
}
