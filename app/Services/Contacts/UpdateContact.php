<?php

namespace App\Services\Contacts;

use App\Models\Contact;
class UpdateContact {
    public function update($request)
    {
        $contact = Contact::findOrFail($request->id);

        $contact->fill($request->all());
        $contact->save();

        return $contact;
    }
}
