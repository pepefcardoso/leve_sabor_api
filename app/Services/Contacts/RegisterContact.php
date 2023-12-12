<?php

namespace App\Services\Contacts;

use App\Models\Contact;
use App\Services\Phones\RegisterPhone;

class RegisterContact
{
    public function register($request, RegisterPhone $registerPhone)
    {
        $contact = Contact::create($request->all());

        $phones = $request->get('phones');

        if ($phones) {
            foreach ($phones as $phone) {
                $phone = $registerPhone->register($phone, $contact->id);
            }
        }

        return $contact;
    }
}
