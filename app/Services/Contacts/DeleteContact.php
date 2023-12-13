<?php

namespace App\Services\Contacts;

use App\Models\Contact;
use App\Services\Phones\DeletePhone;

class DeleteContact
{
    public function __construct(DeletePhone $deletePhone)
    {
        $this->deletePhone = $deletePhone;
    }

    public function delete($id)
    {
        $contact = Contact::with('phone')->findOrFail($id);

        $phones = $contact->phones;

        if ($phones) {
            foreach ($phones as $phone) {
                $this->deletePhone->delete($phone->id);
            }
        }

        $contact->delete();

        return $contact;
    }
}
