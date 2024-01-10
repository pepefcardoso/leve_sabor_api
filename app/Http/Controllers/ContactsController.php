<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Phone;
use App\Services\Contacts\DeleteContact;
use App\Services\Contacts\RegisterContact;
use App\Services\Contacts\SearchContacts;
use App\Services\Contacts\ShowContact;
use App\Services\Contacts\UpdateContact;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index(SearchContacts $searchContacts, int $businessId)
    {
        $filters = ['businessId' => $businessId];

        $contacts = $searchContacts->search($filters);

        return response()->json($contacts);
    }

    public function store(Request $request, RegisterContact $registerContact, int $businessId)
    {
        $data = $request->validate([
            ...Contact::rules(),
            'phones' => 'nullable|array',
            ...Phone::contactRules(),
        ]);

        $contact = $registerContact->register($data, $businessId);

        return response()->json($contact->load('phone'));
    }

    public function show(ShowContact $showContact, int $businessId, int $id)
    {
        $contact = $showContact->show($id);

        return response()->json($contact);
    }

    public function update(Request $request, UpdateContact $updateContact, int $businessId, int $id)
    {
        $this->authorize('update', Contact::class);

        $data = $request->validate([
            ...Contact::rules(),
            'phones' => 'nullable|array',
            ...Phone::contactRules(),
        ]);

        $contact = $updateContact->update($data, $id);

        return response()->json($contact);
    }

    public function destroy(DeleteContact $deleteContact, int $businessId, int $id)
    {
        $this->authorize('delete', Contact::class);

        $contact = $deleteContact->delete($id);

        return response()->json($contact);
    }
}
