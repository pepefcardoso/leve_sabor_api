<?php

namespace App\Http\Controllers;

use App\Services\Phones\DeletePhone;
use App\Services\Phones\RegisterPhone;
use App\Services\Phones\SearchPhones;
use App\Services\Phones\ShowPhone;
use App\Services\Phones\UpdatePhone;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    //
    //
    public function index(SearchPhones $searchPhones, int $contactId)
    {
        $filters = ['contactId' => $contactId];

        $phones = $searchPhones->search($filters);

        return response()->json($phones);
    }

    public function store(Request $request, RegisterPhone $registerPhone, int $contactId)
    {
        $request->validate([
            'number' => 'required|string|min:10|max:11',
            'whatsapp' => 'nullable|boolean',
        ]);

        $phone = $registerPhone->register($request, $contactId);

        return response()->json($phone);
    }

    public function show(ShowPhone $showPhone, int $id)
    {
        $phone = $showPhone->show($id);

        return response()->json($phone);
    }

    public function update(Request $request, UpdatePhone $updatePhone, int $id)
    {
        $request->validate([
            'number' => 'required|string|min:10|max:11',
            'whatsapp' => 'nullable|boolean',
        ]);

        $phone = $updatePhone->update($request, $id);

        return response()->json($phone);
    }

    public function destroy(DeletePhone $deletePhone, int $id)
    {
        $phone = $deletePhone->delete($id);

        return response()->json($phone);
    }
}
