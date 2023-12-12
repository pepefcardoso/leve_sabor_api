<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
        $category = $registerCategory->register($request);

        return response()->json($category);
    }

    public function show(int $id, ShowCategory $showCategory)
    {
        $category = $showCategory->show($id);

        return response()->json($category);
    }

    public function update(Request $request, int $id, UpdateCategory $updateCategory)
    {
        $category = $updateCategory->update($request, $id);

        return response()->json($category);
    }

    public function destroy(int $id, DeleteCategory $deleteCategory)
    {
        $category = $deleteCategory->delete($id);

        return response()->json($category);
    }
}
