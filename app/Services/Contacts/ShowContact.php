<?php

namespace App\Services\Contacts;

use App\Models\Contact;

class ShowContact
{
    public function show($request)
    {
        $contact = Contact::findOrFail($request->id);

        return $contact;
    }
}
