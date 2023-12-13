<?php

namespace App\Services\Contacts;

use App\Models\Contact;
use App\Services\Phones\DeletePhone;
use Illuminate\Support\Facades\DB;

class DeleteContact
{
    public function __construct(DeletePhone $deletePhone)
    {
        $this->deletePhone = $deletePhone;
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $contact = Contact::with('phone')->findOrFail($id);

            $phones = $contact->phones;

            if ($phones) {
                foreach ($phones as $phone) {
                    $this->deletePhone->delete($phone->id);
                }
            }

            $contact->delete();

            DB::commit();

            return $contact;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
