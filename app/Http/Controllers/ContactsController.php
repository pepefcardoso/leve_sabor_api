<?php

namespace App\Http\Controllers;

use App\Services\Contacts\DeleteContact;
use App\Services\Contacts\RegisterContact;
use App\Services\Contacts\SearchContacts;
use App\Services\Contacts\ShowContact;
use App\Services\Contacts\UpdateContact;
use App\Services\Phones\RegisterPhone;
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
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'facebook' => 'nullable|string|min:3|max:99',
            'instagram' => 'nullable|string|min:3|max:99',
            'ifood' => 'nullable|string|min:3|max:99',
            'phones' => 'nullable|array',
            'phones.*.number' => 'required|string|min:10|max:11',
            'phones.*.whatsapp' => 'nullable|boolean',
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
        $data = $request->validate([
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'facebook' => 'nullable|string|min:3|max:99',
            'instagram' => 'nullable|string|min:3|max:99',
            'ifood' => 'nullable|string|min:3|max:99',
            'phones' => 'nullable|array',
            'phones.*.number' => 'required|string|min:10|max:11',
            'phones.*.whatsapp' => 'nullable|boolean',
        ]);

        $contact = $updateContact->update($data, $id);

        return response()->json($contact);
    }

    public function destroy(DeleteContact $deleteContact, int $businessId, int $id)
    {
        $contact = $deleteContact->delete($id);

        return response()->json($contact);
    }
}
