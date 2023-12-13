<?php

namespace App\Services\Adresses;

use App\Models\Adress;
use Illuminate\Support\Facades\DB;

class RegisterAdress
{
    public function register(array $data)
    {
        DB::beginTransaction();

        try {
            $adress = Adress::create($data);

            DB::commit();

            return $adress;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
