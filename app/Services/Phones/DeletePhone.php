<?php

namespace App\Services\Phones;

use App\Models\Phone;
use Illuminate\Support\Facades\DB;

class DeletePhone
{
    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $phone = Phone::findOrFail($id);

            $phone->delete();

            DB::commit();

            return $phone;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
