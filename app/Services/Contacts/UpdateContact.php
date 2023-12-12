<?php

namespace App\Services\Contacts;

use App\Models\Contact;
use App\Services\Phones\DeletePhone;
use App\Services\Phones\RegisterPhone;
use App\Services\Phones\UpdatePhone;
use Illuminate\Http\Request;

class UpdateContact
{
    public function update(Request $request, int $contactId, RegisterPhone $registerPhone, UpdatePhone $updatePhone, DeletePhone $deletePhone,)
    {
        $contact = Contact::findOrFail($contactId);
        $currentPhoneIds = $contact->phone->pluck('id')->toArray();

        $contact->fill($request->all());
        $contact->save();

        $phones = $request->get('phones');

        $updatedPhoneIds = [];
        if ($phones) {
            foreach ($phones as $phone) {
                if (isset($phone['id'])) {
                    $updatePhone->update($phone, $contact->id);
                    $updatedPhoneIds[] = $phone['id'];
                } else {
                    $newPhone = $registerPhone->register($phone, $contact->id);
                    $updatedPhoneIds[] = $newPhone->id; // Supondo que 'register' retorna o telefone registrado
                }
            }
        }

        $deletedPhoneIds = array_diff($currentPhoneIds, $updatedPhoneIds);

        if ($deletedPhoneIds) {
            foreach ($deletedPhoneIds as $phoneId) {
                $deletePhone->delete($phoneId);
            }
        }

        return $contact->load('phone');
    }
}
