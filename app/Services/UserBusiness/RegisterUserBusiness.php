<?php

namespace App\Services\UserBusiness;

use App\Models\Business;
use App\Services\Addresses\RegisterAddress;
use App\Services\Contacts\RegisterContact;
use Illuminate\Support\Facades\DB;

class RegisterUserBusiness
{
    public function __construct(RegisterAddress $registerAddress, RegisterContact $registerContact)
    {
        $this->registerAddress = $registerAddress;
        $this->registerContact = $registerContact;
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

            $contact = data_get($data, 'contact');

            if ($contact) {
                $this->registerContact->register($contact, $userBusiness->id);
            }

            DB::commit();

            return $userBusiness;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
