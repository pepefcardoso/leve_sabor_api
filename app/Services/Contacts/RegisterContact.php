<?php

namespace App\Services\Contacts;

use App\Models\Contact;

class RegisterContact
{
    public function register($request)
    {
        $contact = Contact::create($request->all());

        return $contact;
    }
}
