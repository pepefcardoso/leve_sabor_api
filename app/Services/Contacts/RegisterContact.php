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

            $phones = $data['phones'] ?? [];

            if (count($phones) > 2) {
                throw new \Exception("A contact can have at most 2 phones.");
            }

            foreach ($phones as $phone) {
                $this->registerPhone->register($phone, $contact->id);
            }

            DB::commit();

            return $contact;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
