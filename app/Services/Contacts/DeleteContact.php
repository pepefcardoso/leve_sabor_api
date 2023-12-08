<?php

namespace App\Services\Contacts;

use App\Models\Contact;

class DeleteContact
{
    public function delete($request)
    {
        $contact = Contact::findOrFail($request->id);

        $contact->delete();

        return $contact;
    }
}
