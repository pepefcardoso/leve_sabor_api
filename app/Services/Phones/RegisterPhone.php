<?php

namespace App\Services\Phones;

use App\Models\Phone;
use Illuminate\Support\Facades\DB;

class RegisterPhone
{
    public function register(array $data, int $contactId)
    {
        DB::beginTransaction();

        try {
            $data['contact_id'] = $contactId;

            $phone = Phone::create($data);

            DB::commit();

            return $phone;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
