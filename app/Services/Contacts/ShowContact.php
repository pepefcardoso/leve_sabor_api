<?php

namespace App\Services\Contacts;

use App\Models\Contact;

class ShowContact
{
    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        return $contact->load('phone');
    }
}
