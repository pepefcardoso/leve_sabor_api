<?php

namespace App\Services\Diets;

use App\Models\Diet;

class DeleteDiet
{
    public function delete($id)
    {
        $diet = Diet::findOrFail($id);

        $diet->delete();

        return $diet;
    }
}
