<?php

namespace App\Http\Controllers;

use App\Models\CookingStyle;
use Illuminate\Http\Request;

class CookingStyleController extends Controller
{
    //
    public function index()
    {
        $cookingStyles = CookingStyle::all();

        return response()->json($cookingStyles, 200);
    }

    public function store(Request $request)
    {
        $cookingStyle = CookingStyle::create($request->all());

        return response()->json($cookingStyle, 201);
    }

    public function show(int $id)
    {
        $cookingStyle = CookingStyle::findOrFail($id);

        if (is_null($cookingStyle)) {
            return response()->json('', 204);
        }

        return response()->json($cookingStyle, 200);
    }

    public function update(Request $request)
    {
        $cookingStyle = CookingStyle::findOrFail($request->id);

        if (is_null($cookingStyle)) {
            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);
        }

        $cookingStyle->fill($request->all());
        $cookingStyle->save();

        return response()->json($cookingStyle, 200);
    }

    public function destroy(Request $request)
    {
        $cookingStyle = CookingStyle::findOrFail($request->id);

        if (is_null($cookingStyle)) {
            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);
        }

        $cookingStyle->delete();

        return response()->json('', 204);
    }
}
