<?php

namespace App\Services\UserBusiness;

use App\Models\Business;
use App\Services\Addresses\DeleteAddress;
use App\Services\Contacts\DeleteContact;
use Illuminate\Support\Facades\DB;

class DeleteUserBusiness
{
    public function __construct(DeleteAddress $deleteAddress, DeleteContact $deleteContact)
    {
        $this->deleteAddress = $deleteAddress;
        $this->deleteContact = $deleteContact;
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

            $contact = $userBusiness->contact;

            if ($contact) {
                $this->deleteContact->delete($contact->id);
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
