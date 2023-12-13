<?php

namespace App\Services\Phones;

use App\Models\Phone;
use Illuminate\Support\Facades\DB;

class UpdatePhone
{
    public function update($request, $id)
    {
        DB::beginTransaction();

        try {
            $phone = Phone::findOrFail($id);

            $phone->fill($request);
            $phone->save();

            DB::commit();

            return $phone;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
