<?php

namespace App\Services\Contacts;

use App\Models\Contact;

class SearchContacts
{
    public function search()
    {
        $contacts = Contact::with('phone')->get();

        return $contacts;
    }
}
