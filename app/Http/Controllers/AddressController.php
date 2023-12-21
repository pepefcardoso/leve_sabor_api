<?php

namespace App\Http\Controllers;

use App\Services\Addresses\DeleteAddress;
use App\Services\Addresses\RegisterAddress;
use App\Services\Addresses\SearchAddress;
use App\Services\Addresses\ShowAddress;
use App\Services\Addresses\UpdateAddress;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    //
    public function index(SearchAddress $searchAddress, int $businessId)
    {
        $filters = ['businessId' => $businessId];

        $addresses = $searchAddress->search($filters);

        return response()->json($addresses);
    }

    public function store(Request $request, RegisterAddress $registerAddress, int $businessId)
    {
        $data = $request->validate([
            'street' => 'nullable|string|min:3|max:99',
            'number' => 'nullable|string|min:1|max:10',
            'complement' => 'nullable|string|min:3|max:99',
            'district' => 'nullable|string|min:3|max:99',
            'city' => 'nullable|string|min:3|max:99',
            'state' => 'nullable|string|min:2|max:2',
            'zip_code' => 'required|string|min:8|max:8',
            'latitude' => 'nullable|string|min:3|max:99',
            'longitude' => 'nullable|string|min:3|max:99',
        ]);

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
        $data = $request->validate([
            'street' => 'nullable|string|min:3|max:99',
            'number' => 'nullable|string|min:1|max:10',
            'complement' => 'nullable|string|min:3|max:99',
            'district' => 'nullable|string|min:3|max:99',
            'city' => 'nullable|string|min:3|max:99',
            'state' => 'nullable|string|min:2|max:2',
            'zip_code' => 'required|string|min:8|max:8',
            'latitude' => 'nullable|string|min:3|max:99',
            'longitude' => 'nullable|string|min:3|max:99',
        ]);

        $address = $updateAddress->update($data, $id);

        return response()->json($address);
    }

    public function destroy(DeleteAddress $deleteAddress, int $businessId, int $id)
    {
        $address = $deleteAddress->delete($id);

        return response()->json($address);
    }
}
