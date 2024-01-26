<?php

namespace App\Services\UserBusiness;

use App\Models\Business;
use App\Services\Addresses\DeleteAddress;
use App\Services\Addresses\RegisterAddress;
use App\Services\Addresses\UpdateAddress;
use App\Services\BusinessImages\DeleteBusinessImage;
use App\Services\BusinessImages\RegisterBusinessImage;
use App\Services\BusinessImages\UpdateBusinessImage;
use App\Services\Contacts\DeleteContact;
use App\Services\Contacts\RegisterContact;
use App\Services\Contacts\UpdateContact;
use App\Services\OpeningHours\DeleteOpeningHours;
use App\Services\OpeningHours\RegisterOpeningHours;
use App\Services\OpeningHours\UpdateOpeningHours;
use Exception;
use Illuminate\Support\Facades\DB;

class UpdateUserBusiness
{
    private RegisterAddress $registerAddress;
    private UpdateAddress $updateAddress;
    private DeleteAddress $deleteAddress;
    private RegisterContact $registerContact;
    private UpdateContact $updateContact;
    private DeleteContact $deleteContact;
    private RegisterOpeningHours $registerOpeningHours;
    private UpdateOpeningHours $updateOpeningHours;
    private DeleteOpeningHours $deleteOpeningHours;
    private RegisterBusinessImage $registerBusinessImage;
    private UpdateBusinessImage $updateBusinessImage;
    private DeleteBusinessImage $deleteBusinessImage;


    public function __construct(
        RegisterAddress       $registerAddress, UpdateAddress $updateAddress, DeleteAddress $deleteAddress,
        RegisterContact       $registerContact, UpdateContact $updateContact, DeleteContact $deleteContact,
        RegisterOpeningHours  $registerOpeningHours, UpdateOpeningHours $updateOpeningHours, DeleteOpeningHours $deleteOpeningHours,
        RegisterBusinessImage $registerBusinessImage, UpdateBusinessImage $updateBusinessImage, DeleteBusinessImage $deleteBusinessImage)
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
        $this->registerBusinessImage = $registerBusinessImage;
        $this->updateBusinessImage = $updateBusinessImage;
        $this->deleteBusinessImage = $deleteBusinessImage;
    }

    public function update(array $data, int $id): Business|string
    {
        DB::beginTransaction();

        try {
            $userBusiness = Business::findOrFail($id);

            $diets = data_get($data, 'diets_id');
            throw_if(empty($diets), Exception::class, 'Diets are required');
            $userBusiness->diet()->sync($diets);

            $main_diet = data_get($data, 'main_diet_id');
            throw_if(empty($main_diet), Exception::class, 'Main diet is required');
            $userBusiness->main_diet_id = $main_diet;

            $cooking_styles = data_get($data, 'cooking_styles_ids');
            throw_if(empty($cooking_styles), Exception::class, 'Cooking styles are required');
            $userBusiness->cookingStyle()->sync($cooking_styles);

            $userBusiness->fill($data);
            $userBusiness->save();

            $address = data_get($data, 'address');
            if ($address) {
                if (isset($address['id'])) {
                    $response = $this->updateAddress->update($address, $userBusiness->id);
                    throw_if(is_string($response), Exception::class, $response);
                } else {
                    $response = $this->registerAddress->register($address, $userBusiness->id);
                    throw_if(is_string($response), Exception::class, $response);
                }
            } else {
                $response = $this->deleteAddress->delete($userBusiness->id);
                throw_if(is_string($response), Exception::class, $response);
            }

            $contact = data_get($data, 'contact');
            if ($contact) {
                if (isset($contact['id'])) {
                    $response = $this->updateContact->update($contact, $userBusiness->id);
                    throw_if(is_string($response), Exception::class, $response);
                } else {
                    $response = $this->registerContact->register($contact, $userBusiness->id);
                    throw_if(is_string($response), Exception::class, $response);
                }
            } else {
                $response = $this->deleteContact->delete($userBusiness->id);
                throw_if(is_string($response), Exception::class, $response);
            }

            $openingHours = data_get($data, 'opening_hours');
            if ($openingHours) {
                $usedWeekdays = [];
                foreach ($openingHours as $openingHour) {
                    $weekday = $openingHour['week_day'] ?? null;
                    if ($weekday !== null && in_array($weekday, $usedWeekdays)) {
                        throw new Exception("Only one opening hour allowed per weekday.");
                    }
                    if ($weekday !== null) {
                        $usedWeekdays[] = $weekday;
                    }

                    if (isset($openingHour['id'])) {
                        $response = $this->updateOpeningHours->update($openingHour, $userBusiness->id);
                        throw_if(is_string($response), Exception::class, $response);
                    } else {
                        $response = $this->registerOpeningHours->register($openingHour, $userBusiness->id);
                        throw_if(is_string($response), Exception::class, $response);
                    }
                }
            } else {
                $response = $this->deleteOpeningHours->delete($userBusiness->id);
                throw_if(is_string($response), Exception::class, $response);
            }

            $currentImagesIds = $userBusiness->businessImages->pluck('id')->toArray();

            $newImages = data_get($data, 'images');

            $updatedImagesIds = [];

            if ($newImages) {
                foreach ($newImages as $image) {
                    $imageId = data_get($image, 'id');
                    $imageFile = data_get($image, 'file');

                    if ($imageFile && !$imageId) {
                        $newImage = $response = $this->registerBusinessImage->register($image, $userBusiness->id);
                        throw_if(is_string($response), Exception::class, $response);
                        $updatedImagesIds[] = $newImage->id;

                    } elseif ($imageFile && $imageId) {
                        $response = $this->updateBusinessImage->update($image, $imageId, $userBusiness->id);
                        throw_if(is_string($response), Exception::class, $response);
                        $updatedImagesIds[] = $imageId;
                    }
                }
            }

            $deletedImagesIds = array_diff($currentImagesIds, $updatedImagesIds);

            if ($deletedImagesIds) {
                foreach ($deletedImagesIds as $imageId) {
                    $response = $this->deleteBusinessImage->delete($imageId);
                    throw_if(is_string($response), Exception::class, $response);
                }
            }

            DB::commit();

            return $userBusiness;
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

}
