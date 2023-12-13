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

    public function register($request)
    {
        DB::beginTransaction();

        try {
            $contact = Contact::create($request->all());

            $phones = $request->get('phones');

            if ($phones) {
                foreach ($phones as $phone) {
                    $phone = $this->registerPhone->register($phone, $contact->id);
                }
            }

            DB::commit();

            return $contact;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
