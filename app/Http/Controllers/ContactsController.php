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
    public function index(SearchContacts $searchContacts)
    {
        $contacts = $searchContacts->search();

        return response()->json($contacts);
    }

    public function store(Request $request, RegisterContact $registerContact)
    {
        $request->validate([
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'facebook' => 'nullable|string|min:3|max:99',
            'instagram' => 'nullable|string|min:3|max:99',
            'ifood' => 'nullable|string|min:3|max:99',
            'phones' => 'nullable|array',
        ]);

        $contact = $registerContact->register($request);


//        $phones = $request->get('phones');

//        foreach ($phones as $phone) {
//            $registerPhone->register($phone, $contact->id);
//        }

        return response()->json($contact->load('phone'));
    }

    public function show(ShowContact $showContact, int $id)
    {
        $contact = $showContact->show($id);

        return response()->json($contact);
    }

    public function update(Request $request, UpdateContact $updateContact, int $id)
    {
        $request->validate([
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'facebook' => 'nullable|string|min:3|max:99',
            'instagram' => 'nullable|string|min:3|max:99',
            'ifood' => 'nullable|string|min:3|max:99',
            'phones' => 'nullable|array',
        ]);

        $contact = $updateContact->update($request, $id);

//        $phones = $request->get('phones');
//
//        foreach ($phones as $phone) {
//            $updatePhone->update($phone, $contact->id, $phone['id']);
//        }

        return response()->json($contact);
    }

    public function destroy(DeleteContact $deleteContact, int $id)
    {
        $contact = $deleteContact->delete($id);

        return response()->json($contact);
    }
}
