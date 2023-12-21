<?php

namespace App\Services\Contacts;

use App\Models\Contact;

class SearchContacts
{
    public function search(array $filters)
    {
        $contacts = Contact::where('business_id', $filters['businessId'])
            ->with('phone')
            ->get();

        return $contacts;
    }
}
