<?php

namespace App\Services\Contacts;

use App\Models\Contact;
use App\Services\Phones\RegisterPhone;

class RegisterContact
{
    public function __construct(RegisterPhone $registerPhone)
    {
        $this->registerPhone = $registerPhone;
    }

    public function register($request)
    {
        $contact = Contact::create($request->all());

        $phones = $request->get('phones');

        if ($phones) {
            foreach ($phones as $phone) {
                $phone = $this->registerPhone->register($phone, $contact->id);
            }
        }

        return $contact;
    }
}
