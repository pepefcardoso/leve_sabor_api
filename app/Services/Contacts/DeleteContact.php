<?php

namespace App\Services\Contacts;

use App\Models\Contact;

class DeleteContact
{
    public function delete($id)
    {
        $contact = Contact::findOrFail($id);

        $contact->delete();

        return $contact;
    }
}
