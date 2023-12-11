<?php

namespace App\Services\Diets;

use App\Models\Diet;

class ShowDiet
{
    public function show($id)
    {
        $diet = Diet::where('id', $id)
            ->firstOrFail();

        return $diet;
    }
}
