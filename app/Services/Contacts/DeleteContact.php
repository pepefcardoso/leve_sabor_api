<?php

namespace App\Services\Contacts;

use App\Models\Contact;
use App\Services\Phones\DeletePhone;

class DeleteContact
{
    public function delete($id, DeletePhone $deletePhone)
    {
        $contact = Contact::with('phones')->findOrFail($id);

        foreach ($contact->phones as $phone) {
            $deletePhone->delete($phone->id);
        }

        $contact->delete();

        return $contact;
    }
}
