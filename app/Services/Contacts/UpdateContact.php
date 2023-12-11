<?php

namespace App\Services\Contacts;

use App\Models\Contact;
class UpdateContact {
    public function update($request, $contactId)
    {
        $contact = Contact::findOrFail($contactId);

        $contact->fill($request->all());
        $contact->save();

        return $contact->load('phone');
    }
}
