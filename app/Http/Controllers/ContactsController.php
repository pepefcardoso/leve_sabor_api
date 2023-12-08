<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index()
    {
        $contacts = Contacts::all();

        return response()->json($contacts, 200);
    }

    public function store(Request $request)
    {
        $contact = Contacts::create($request->all());

        return response()->json($contact, 201);
    }

    public function show(int $id)
    {
        $contact = Contacts::findOrFail($id);

        if (is_null($contact)) {
            return response()->json('', 204);
        }

        return response()->json($contact, 200);
    }

    public function update(Request $request)
    {
        $contact = Contacts::findOrFail($request->id);

        if (is_null($contact)) {
            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);
        }

        $contact->fill($request->all());
        $contact->save();

        return response()->json($contact, 200);
    }

    public function destroy(Request $request)
    {
        $contact = Contacts::findOrFail($request->id);

        if (is_null($contact)) {
            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);
        }

        $contact->delete();

        return response()->json('', 204);
    }
}
