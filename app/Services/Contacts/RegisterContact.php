<?php

namespace App\Services\Contacts;

use App\Models\Contact;
use App\Services\Phones\RegisterPhone;
use Illuminate\Support\Facades\DB;

class RegisterContact
{
    public function __construct(RegisterPhone $registerPhone)
    {
        $this->registerPhone = $registerPhone;
    }

    public function register(array $data, int $businessId)
    {
        DB::beginTransaction();

        try {
            $data['business_id'] = $businessId;

            $contact = Contact::create($data);

            $phones = data_get($data, 'phones');

            throw_if(empty($phones), new \Exception("A contact must have at least 1 phone."));

            throw_if(count($phones) > 2, new \Exception("A contact can have a maximum of 2 phones."));

            foreach ($phones as $phone) {
                $response = $this->registerPhone->register($phone, $contact->id);
                throw_if(is_string($response), \Exception::class, $response);
            }

            DB::commit();

            return $contact;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
