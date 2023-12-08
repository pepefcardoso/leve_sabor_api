<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Services\Contacts\DeleteContact;
use App\Services\Contacts\RegisterContact;
use App\Services\Contacts\SearchContacts;
use App\Services\Contacts\ShowContact;
use App\Services\Contacts\UpdateContact;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index(Request $request, SearchContacts $searchContacts)
    {
        $contacts = $searchContacts->search();

        return response()->json($contacts);
    }

    public function store(Request $request, RegisterContact $registerContact)
    {
        $contact = $registerContact->register($request->all());

        return response()->json($contact);
    }

    public function show(Request $request, ShowContact $showContact)
    {
        $contact = $showContact->show($request->all());

        return response()->json($contact);
    }

    public function update(Request $request, UpdateContact $updateContact)
    {
        $contact = $updateContact->update($request->all());

        return response()->json($contact);
    }

    public function destroy(Request $request, DeleteContact $deleteContact)
    {
        $contact = $deleteContact->delete($request->all());

        return response()->json($contact);
    }
}
