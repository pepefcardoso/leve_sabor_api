<?php

namespace App\Services\UserBusiness;

use App\Models\Business;
use Illuminate\Support\Facades\DB;

class RegisterUserBusiness
{
    public function register(array $data, int $userId)
    {
        DB::beginTransaction();

        try {
            $data['user_id'] = $userId;

            $userBusiness = Business::create($data);

            DB::commit();

            return $userBusiness;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
