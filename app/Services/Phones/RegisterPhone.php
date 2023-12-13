<?php

namespace App\Services\Phones;

use App\Models\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterPhone
{
    public function register($request, $contactId)
    {
        DB::beginTransaction();

        try {
            $request['contact_id'] = $contactId;

            if ($request instanceof Request) {
                $phone = Phone::create($request->all());
            } else {
                $phone = Phone::create($request);
            }

            DB::commit();

            return $phone;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
