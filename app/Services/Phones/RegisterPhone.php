<?php

namespace App\Services\Phones;

use App\Models\Phone;
use Illuminate\Support\Facades\DB;

class RegisterPhone
{
    public function register($request, $contactId)
    {
        DB::beginTransaction();

        try {
            $request['contact_id'] = $contactId;

            $phone = Phone::create($request->all());

            DB::commit();

            return $phone;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
