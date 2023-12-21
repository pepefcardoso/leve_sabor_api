<?php

namespace App\Services\UserBusiness;

use App\Models\Business;
use App\Services\Addresses\RegisterAddress;
use Illuminate\Support\Facades\DB;

class RegisterUserBusiness
{
    public function __construct(RegisterAddress $registerAddress)
    {
        $this->registerAddress = $registerAddress;
    }

    public function register(array $data, int $userId)
    {
        DB::beginTransaction();

        try {
            $data['user_id'] = $userId;

            $userBusiness = Business::create($data);

            $diets = $data['diets_id'] ?? [];

            if (count($diets) > 0) {
                $userBusiness->diet()->attach($diets);
            }

            $address = data_get($data, 'address');

            if ($address) {
                $this->registerAddress->register($address, $userBusiness->id);
            }

            DB::commit();

            return $userBusiness;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
