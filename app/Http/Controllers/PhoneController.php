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
    public function index(Request $request, SearchPhones $searchPhones, int $contactId)
    {
        $filters = ['contactId' => $contactId];

        $phones = $searchPhones->search($request->all(), $filters);

        return response()->json($phones);
    }

    public function store(Request $request, RegisterPhone $registerPhone, int $contactId)
    {
        $phone = $registerPhone->register($request->all(), $contactId);

        return response()->json($phone);
    }

    public function show(Request $request, ShowPhone $showPhone, int $contactId, int $id)
    {
        $phone = $showPhone->show($contactId, $id);

        return response()->json($phone);
    }

    public function update(Request $request, UpdatePhone $updatePhone, int $contactId, int $id)
    {
        $phone = $updatePhone->update($request, $contactId, $id);

        return response()->json($phone);
    }

    public function destroy(Request $request, DeletePhone $deletePhone, int $contactId, int $id)
    {
        $phone = $deletePhone->delete($request, $contactId, $id);

        return response()->json($phone);
    }
}
