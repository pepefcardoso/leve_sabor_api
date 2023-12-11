<?php

namespace App\Services\Contacts;

use App\Models\Contact;

class DeleteContact
{
    public function delete($request, $contactId)
    {
        $contact = Contact::findOrFail($contactId);

        $contact->delete();

        return $contact;
    }
}
