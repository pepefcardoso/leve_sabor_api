<?php

namespace App\Services\UserBusiness;

use App\Models\Business;
use App\Services\Addresses\DeleteAddress;
use App\Services\Addresses\RegisterAddress;
use App\Services\Addresses\UpdateAddress;
use App\Services\Contacts\DeleteContact;
use App\Services\Contacts\RegisterContact;
use App\Services\Contacts\UpdateContact;
use App\Services\OpeningHours\DeleteOpeningHours;
use App\Services\OpeningHours\RegisterOpeningHours;
use App\Services\OpeningHours\UpdateOpeningHours;
use Illuminate\Support\Facades\DB;

class UpdateUserBusiness
{
    public function __construct(
        RegisterAddress      $registerAddress, UpdateAddress $updateAddress, DeleteAddress $deleteAddress,
        RegisterContact      $registerContact, UpdateContact $updateContact, DeleteContact $deleteContact,
        RegisterOpeningHours $registerOpeningHours, UpdateOpeningHours $updateOpeningHours, DeleteOpeningHours $deleteOpeningHours)
    {
        $this->registerAddress = $registerAddress;
        $this->updateAddress = $updateAddress;
        $this->deleteAddress = $deleteAddress;
        $this->registerContact = $registerContact;
        $this->updateContact = $updateContact;
        $this->deleteContact = $deleteContact;
        $this->registerOpeningHours = $registerOpeningHours;
        $this->updateOpeningHours = $updateOpeningHours;
        $this->deleteOpeningHours = $deleteOpeningHours;
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

            $contact = data_get($data, 'contact');

            if ($contact) {
                if (isset($contact['id'])) {
                    $this->updateContact->update($contact, $userBusiness->id);
                } else {
                    $this->registerContact->register($contact, $userBusiness->id);
                }
            } else {
                $this->deleteContact->delete($userBusiness->id);
            }

            $openingHours = data_get($data, 'opening_hours');

            if ($openingHours) {
                foreach ($openingHours as $openingHour) {
                    if (isset($openingHour['id'])) {
                        $this->updateOpeningHours->update($openingHour, $userBusiness->id);
                    } else {
                        $this->registerOpeningHours->register($openingHour, $userBusiness->id);
                    }
                }
            } else {
                $this->deleteOpeningHours->delete($userBusiness->id);
            }

            DB::commit();

            return $userBusiness;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
