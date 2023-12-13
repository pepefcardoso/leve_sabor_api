<?php

namespace App\Http\Controllers;

use App\Services\Adresses\DeleteAdress;
use App\Services\Adresses\RegisterAdress;
use App\Services\Adresses\SearchAdress;
use App\Services\Adresses\ShowAdress;
use App\Services\Adresses\UpdateAdress;
use Illuminate\Http\Request;

class AdressController extends Controller
{
    //
    public function index(SearchAdress $searchAdress)
    {
        $adresses = $searchAdress->search();

        return response()->json($adresses);
    }

    public function store(Request $request, RegisterAdress $registerAdress)
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

        $adress = $registerAdress->register($data);

        return response()->json($adress);
    }

    public function show(ShowAdress $showAdress, int $id)
    {
        $adress = $showAdress->show($id);

        return response()->json($adress);
    }

    public function update(Request $request, UpdateAdress $updateAdress, int $id)
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

        $adress = $updateAdress->update($data, $id);

        return response()->json($adress);
    }

    public function destroy(DeleteAdress $deleteAdress, int $id)
    {
        $adress = $deleteAdress->delete($id);

        return response()->json($adress);
    }
}
