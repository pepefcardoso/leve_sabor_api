<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Services\Addresses\DeleteAddress;
use App\Services\Addresses\RegisterAddress;
use App\Services\Addresses\SearchAddress;
use App\Services\Addresses\ShowAddress;
use App\Services\Addresses\UpdateAddress;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(SearchAddress $searchAddress, int $businessId)
    {
        $filters = ['businessId' => $businessId];

        $addresses = $searchAddress->search($filters);

        return response()->json($addresses);
    }

    public function store(Request $request, RegisterAddress $registerAddress, int $businessId)
    {
        $data = $request->validate(Address::rules());

        $address = $registerAddress->register($data, $businessId);

        return response()->json($address);
    }

    public function show(ShowAddress $showAddress, int $businessId, int $id)
    {
        $address = $showAddress->show($id);

        return response()->json($address);
    }

    public function update(Request $request, UpdateAddress $updateAddress, int $businessId, int $id)
    {
        $this->authorize('update', Address::class);

        $data = $request->validate(Address::rules());

        $address = $updateAddress->update($data, $id);

        return response()->json($address);
    }

    public function destroy(DeleteAddress $deleteAddress, int $businessId, int $id)
    {
        $this->authorize('delete', Address::class);

        $address = $deleteAddress->delete($id);

        return response()->json($address);
    }
}
