<?php

namespace App\Services\UserBusiness;

use App\Models\Business;
use App\Services\Addresses\DeleteAddress;
use App\Services\Contacts\DeleteContact;
use App\Services\OpeningHours\DeleteOpeningHours;
use Illuminate\Support\Facades\DB;

class DeleteUserBusiness
{
    public function __construct(DeleteAddress $deleteAddress, DeleteContact $deleteContact, DeleteOpeningHours $deleteOpeningHours)
    {
        $this->deleteAddress = $deleteAddress;
        $this->deleteContact = $deleteContact;
        $this->deleteOpeningHours = $deleteOpeningHours;
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

            $openingHours = $userBusiness->openingHours;

            if ($openingHours) {
                foreach ($openingHours as $openingHour) {
                    $this->deleteOpeningHours->delete($openingHour->id);
                }
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
