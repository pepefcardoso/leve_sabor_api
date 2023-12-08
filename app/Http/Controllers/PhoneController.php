<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Phones\RegisterPhone;
use App\Services\Phones\SearchPhones;
use App\Services\Phones\ShowPhone;
use App\Services\Phones\UpdatePhone;
use App\Services\Phones\DeletePhone;

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

    public function show(Request $request, ShowPhone $showPhone)
    {
        $phone = $showPhone->show($request->all());

        return response()->json($phone);
    }

    public function update(Request $request, UpdatePhone $updatePhone)
    {
        $phone = $updatePhone->update($request->all());

        return response()->json($phone);
    }

    public function destroy(Request $request, DeletePhone $deletePhone)
    {
        $phone = $deletePhone->delete($request->all());

        return response()->json($phone);
    }
}
