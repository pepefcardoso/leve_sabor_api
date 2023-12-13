<?php

namespace App\Services\Contacts;

use App\Models\Contact;
use App\Services\Phones\DeletePhone;
use App\Services\Phones\RegisterPhone;
use App\Services\Phones\UpdatePhone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateContact
{
    public function __construct(RegisterPhone $registerPhone, UpdatePhone $updatePhone, DeletePhone $deletePhone)
    {
        $this->registerPhone = $registerPhone;
        $this->updatePhone = $updatePhone;
        $this->deletePhone = $deletePhone;
    }

    public function update(Request $request, int $contactId)
    {
        DB::beginTransaction();

        try {
            $contact = Contact::findOrFail($contactId);
            $currentPhoneIds = $contact->phone->pluck('id')->toArray();

            $contact->fill($request->all());
            $contact->save();

            $phones = $request->get('phones');

            $updatedPhoneIds = [];
            if ($phones) {
                foreach ($phones as $phone) {
                    if (isset($phone['id'])) {
                        $this->updatePhone->update($phone, $contact->id);
                        $updatedPhoneIds[] = $phone['id'];
                    } else {
                        $newPhone = $this->registerPhone->register($phone, $contact->id);
                        $updatedPhoneIds[] = $newPhone->id; // Supondo que 'register' retorna o telefone registrado
                    }
                }
            }

            $deletedPhoneIds = array_diff($currentPhoneIds, $updatedPhoneIds);

            if ($deletedPhoneIds) {
                foreach ($deletedPhoneIds as $phoneId) {
                    $this->deletePhone->delete($phoneId);
                }
            }

            DB::commit();

            return $contact->load('phone');
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
