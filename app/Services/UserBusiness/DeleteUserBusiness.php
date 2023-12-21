<?php

namespace App\Services\UserBusiness;

use App\Models\Business;
use App\Services\Addresses\DeleteAddress;
use Illuminate\Support\Facades\DB;

class DeleteUserBusiness
{
    public function __construct(DeleteAddress $deleteAddress)
    {
        $this->deleteAddress = $deleteAddress;
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $userBusiness = Business::with('address')->findOrFail($id);

            $userBusiness->diet()->detach();

            $address = $userBusiness->address;

            if ($address) {
                $this->deleteAddress->delete($address->id);
            }

            $userBusiness->delete();

            DB::commit();

            return $userBusiness;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
