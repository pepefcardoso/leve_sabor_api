<?php

namespace App\Http\Controllers;

use App\Services\Contacts\DeleteContact;
use App\Services\Contacts\RegisterContact;
use App\Services\Contacts\SearchContacts;
use App\Services\Contacts\ShowContact;
use App\Services\Contacts\UpdateContact;
use App\Services\Phones\RegisterPhone;
use App\Services\Phones\UpdatePhone;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index(Request $request, SearchContacts $searchContacts)
    {
        $contacts = $searchContacts->search();

        return response()->json($contacts);
    }

    public function store(Request $request, RegisterContact $registerContact, RegisterPhone $registerPhone)
    {
        $contact = $registerContact->register($request->all());


        $phones = $request->get('phones');

        foreach ($phones as $phone) {
            $registerPhone->register($phone, $contact->id);
        }

        return response()->json($contact->load('phone'));
    }

    public function show(Request $request, ShowContact $showContact, int $id)
    {
        $contact = $showContact->show($id);

        return response()->json($contact);
    }

    public function update(Request $request, UpdateContact $updateContact, int $id)
    {
        $contact = $updateContact->update($request, $id);

//        $phones = $request->get('phones');
//
//        foreach ($phones as $phone) {
//            $updatePhone->update($phone, $contact->id, $phone['id']);
//        }

        return response()->json($contact);
    }

    public function destroy(Request $request, DeleteContact $deleteContact, int $id)
    {
        $contact = $deleteContact->delete($request, $id);

        return response()->json($contact);
    }
}
