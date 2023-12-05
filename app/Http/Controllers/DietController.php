<?php

namespace App\Http\Controllers;

use App\Models\Diet;
use Illuminate\Http\Request;

class DietController extends Controller
{
    //
    public function index()
    {
        $diets = Diet::all();

        return response()->json($diets, 200);
    }

    public function store(Request $request)
    {
        $diet = Diet::create($request->all());

        return response()->json($diet, 201);
    }

    public function show(int $id)
    {
        $diet = Diet::findOrFail($id);

        if (is_null($diet)) {
            return response()->json('', 204);
        }

        return response()->json($diet, 200);
    }

    public function update(Request $request)
    {
        $diet = Diet::findOrFail($request->id);

        if (is_null($diet)) {
            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);
        }

        $diet->fill($request->all());
        $diet->save();

        return response()->json($diet, 200);
    }

    public function destroy(Request $request)
    {
        $diet = Diet::findOrFail($request->id);

        if (is_null($diet)) {
            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);
        }

        $diet->delete();

        return response()->json('', 204);
    }

}
