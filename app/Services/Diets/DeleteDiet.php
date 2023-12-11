<?php

namespace App\Services\Diets;

use App\Models\Diet;

class DeleteDiet
{
    public function delete($id)
    {
        $diet = Diet::where('id', $id)
            ->firstOrFail();

        $diet->delete();

        return $diet;
    }
}
