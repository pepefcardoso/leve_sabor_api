<?php

namespace App\Services\Contacts;

use App\Models\Contact;
use App\Services\Phones\DeletePhone;
use App\Services\Phones\RegisterPhone;
use App\Services\Phones\UpdatePhone;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdateContact
{
    public function __construct(RegisterPhone $registerPhone, UpdatePhone $updatePhone, DeletePhone $deletePhone)
    {
        $this->registerPhone = $registerPhone;
        $this->updatePhone = $updatePhone;
        $this->deletePhone = $deletePhone;
    }

    public function update(array $data, int $contactId)
    {
        DB::beginTransaction();

        try {
            $contact = Contact::findOrFail($contactId);
            $currentPhoneIds = $contact->phone->pluck('id')->toArray();

            $contact->fill($data);
            $contact->save();

            $phones = $data['phones'] ?? [];

            if (count($phones) > 2) {
                throw new \Exception("A contact can have at most 2 phones.");
            }

            $updatedPhoneIds = [];
            if ($phones) {
                foreach ($phones as $phone) {
                    if (isset($phone['id'])) {
                        $response = $this->updatePhone->update($phone, $contact->id);
                        throw_if(is_string($response), Exception::class, $response);
                        $updatedPhoneIds[] = $phone['id'];
                    } else {
                        $newPhone = $this->registerPhone->register($phone, $contact->id);
                        throw_if(is_string($newPhone), Exception::class, $newPhone);
                        $updatedPhoneIds[] = $newPhone->id;
                    }
                }
            }

            $deletedPhoneIds = array_diff($currentPhoneIds, $updatedPhoneIds);

            if ($deletedPhoneIds) {
                foreach ($deletedPhoneIds as $phoneId) {
                    $response = $this->deletePhone->delete($phoneId);
                    throw_if(is_string($response), Exception::class, $response);
                }
            }

            DB::commit();

            return $contact->load('phone');
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        } catch (Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
