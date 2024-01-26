<?php

namespace App\Services\UserBusiness;

use App\Models\Business;
use App\Services\Addresses\RegisterAddress;
use App\Services\BusinessImages\RegisterBusinessImage;
use App\Services\Contacts\RegisterContact;
use App\Services\OpeningHours\RegisterOpeningHours;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class RegisterUserBusiness
{
    private RegisterAddress $registerAddress;
    private RegisterContact $registerContact;
    private RegisterOpeningHours $registerOpeningHours;
    private RegisterBusinessImage $registerBusinessImage;

    public function __construct(RegisterAddress $registerAddress, RegisterContact $registerContact, RegisterOpeningHours $registerOpeningHours, RegisterBusinessImage $registerBusinessImage)
    {
        $this->registerAddress = $registerAddress;
        $this->registerContact = $registerContact;
        $this->registerOpeningHours = $registerOpeningHours;
        $this->registerBusinessImage = $registerBusinessImage;
    }

    public function register(array $data, int $userId): Business|string
    {
        DB::beginTransaction();

        try {
            $data['user_id'] = $userId;

            $userBusiness = Business::create($data);

            $diets = data_get($data, 'diets_id');

            throw_if(empty($diets), Exception::class, 'Diets is required');

            $userBusiness->diet()->attach($diets);

            $mainDiet = data_get($data, 'main_diet_id');

            throw_if(empty($mainDiet), Exception::class, 'Main diet is required');

            $userBusiness->main_diet_id = $mainDiet;

            $cookingStyles = data_get($data, 'cooking_styles_ids');

            throw_if(empty($cookingStyles), Exception::class, 'Cooking styles is required');

            $userBusiness->cookingStyle()->attach($cookingStyles);

            $address = data_get($data, 'address');

            if ($address) {
                $response = $this->registerAddress->register($address, $userBusiness->id);
                throw_if(is_string($response), Exception::class, $response);
            }

            $contact = data_get($data, 'contact');

            if ($contact) {
                $response = $this->registerContact->register($contact, $userBusiness->id);
                throw_if(is_string($response), Exception::class, $response);
            }

            $openingHours = data_get($data, 'opening_hours');
            if ($openingHours) {
                $usedWeekdays = [];
                foreach ($openingHours as $openingHour) {
                    $weekday = $openingHour['week_day'] ?? null;
                    if ($weekday !== null && in_array($weekday, $usedWeekdays, true)) {
                        throw new Exception("Only one opening hour allowed per week day.");
                    }
                    if ($weekday !== null) {
                        $usedWeekdays[] = $weekday;
                    }
                    $response = $this->registerOpeningHours->register($openingHour, $userBusiness->id);
                    throw_if(is_string($response), Exception::class, $response);
                }
            }

            $images = data_get($data, 'images');

            if ($images) {
                foreach ($images as $image) {
                    $response = $this->registerBusinessImage->register($image, $userBusiness->id);
                    throw_if(is_string($response), Exception::class, $response);
                }
            }

            DB::commit();

            return $userBusiness;
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        } catch (Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
