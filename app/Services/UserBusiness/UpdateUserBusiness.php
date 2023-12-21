<?php

namespace App\Services\UserBusiness;

use App\Models\Business;
use App\Services\Addresses\DeleteAddress;
use App\Services\Addresses\RegisterAddress;
use App\Services\Addresses\UpdateAddress;
use Illuminate\Support\Facades\DB;

class UpdateUserBusiness
{
    public function __construct(RegisterAddress $registerAddress, UpdateAddress $updateAddress, DeleteAddress $deleteAddress)
    {
        $this->registerAddress = $registerAddress;
        $this->updateAddress = $updateAddress;
        $this->deleteAddress = $deleteAddress;
    }

    public function update(array $data, int $id)
    {
        DB::beginTransaction();

        try {
            $userBusiness = Business::findOrFail($id);

            $diets = $data['diets_id'] ?? [];

            if (count($diets) > 0) {
                $userBusiness->diet()->sync($diets);
            }

            $userBusiness->fill($data);
            $userBusiness->save();

            $address = data_get($data, 'address');

            if ($address) {
                if (isset($address['id'])) {
                    $this->updateAddress->update($address, $userBusiness->id);
                } else {
                    $this->registerAddress->register($address, $userBusiness->id);
                }
            } else {
                $this->deleteAddress->delete($userBusiness->id);
            }

            DB::commit();

            return $userBusiness;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
