<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    //
    public function index()
    {
        $categories = Category::all();

        return response()->json($categories, 200);
    }

    public function store(Request $request)
    {
        $category = Category::create($request->all());

        return response()->json($category, 201);
    }

    public function show(int $id)
    {
        $category = Category::findOrFail($id);

        if (is_null($category)) {
            return response()->json('', 204);
        }

        return response()->json($category, 200);
    }

    public function update(Request $request)
    {
        $category = Category::findOrFail($request->id);

        if (is_null($category)) {
            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);
        }

        $category->fill($request->all());
        $category->save();

        return response()->json($category, 200);
    }

    public function destroy(Request $request)
    {
        $category = Category::findOrFail($request->id);

        if (is_null($category)) {
            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);
        }

        $category->delete();

        return response()->json('', 204);
    }
}
