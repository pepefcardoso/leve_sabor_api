<?php

namespace App\Http\Controllers;

use App\Services\Categories\DeleteCategory;
use App\Services\Categories\RegisterCategory;
use App\Services\Categories\SearchCategories;
use App\Services\Categories\ShowCategory;
use App\Services\Categories\UpdateCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    //
    public function index(SearchCategories $searchCategories)
    {
        $categories = $searchCategories->search();

        return response()->json($categories);
    }

    public function store(Request $request, RegisterCategory $registerCategory)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:30',
        ]);

        $category = $registerCategory->register($request);

        return response()->json($category);
    }

    public function show(ShowCategory $showCategory, int $id)
    {
        $category = $showCategory->show($id);

        return response()->json($category);
    }

    public function update(Request $request, UpdateCategory $updateCategory, int $id)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:30',
        ]);

        $category = $updateCategory->update($request, $id);

        return response()->json($category);
    }

    public function destroy(DeleteCategory $deleteCategory, int $id)
    {
        $category = $deleteCategory->delete($id);

        return response()->json($category);
    }
}
