<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    //
    //
    public function index()
    {
        $phones = Phone::all();

        return response()->json($phones, 200);
    }

    public function store(Request $request)
    {
        $phone = Phone::create($request->all());

        return response()->json($phone, 201);
    }

    public function show(int $id)
    {
        $phone = Phone::findOrFail($id);

        if (is_null($phone)) {
            return response()->json('', 204);
        }

        return response()->json($phone, 200);
    }

    public function update(Request $request)
    {
        $phone = Phone::findOrFail($request->id);

        if (is_null($phone)) {
            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);
        }

        $phone->fill($request->all());
        $phone->save();

        return response()->json($phone, 200);
    }

    public function destroy(Request $request)
    {
        $phone = Phone::findOrFail($request->id);

        if (is_null($phone)) {
            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);
        }

        $phone->delete();

        return response()->json('', 204);
    }
}
