<?php

namespace App\Services\UserBusiness;

use App\Models\Business;
use App\Services\Addresses\DeleteAddress;
use App\Services\BusinessImages\DeleteBusinessImage;
use App\Services\Contacts\DeleteContact;
use App\Services\OpeningHours\DeleteOpeningHours;
use Illuminate\Support\Facades\DB;

class DeleteUserBusiness
{
    public function __construct(DeleteAddress $deleteAddress, DeleteContact $deleteContact, DeleteOpeningHours $deleteOpeningHours, DeleteBusinessImage $deleteBusinessImage)
    {
        $this->deleteAddress = $deleteAddress;
        $this->deleteContact = $deleteContact;
        $this->deleteOpeningHours = $deleteOpeningHours;
        $this->deleteBusinessImage = $deleteBusinessImage;
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $userBusiness = Business::with('address')->findOrFail($id);

            $userBusiness->diet()->detach();

            $userBusiness->cookingStyle()->detach();

            $businessImage = $userBusiness->businessImage;

            if ($businessImage) {
                foreach ($businessImage as $image) {
                    $this->deleteBusinessImage->delete($image->id);
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
