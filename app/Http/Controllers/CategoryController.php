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
        $this->authorize('create', Category::class);

        $data = $request->validate([
            'name' => 'required|string|min:3|max:30',
        ]);

        $category = $registerCategory->register($data);

        return response()->json($category);
    }

    public function show(ShowCategory $showCategory, int $id)
    {
        $category = $showCategory->show($id);

        return response()->json($category);
    }

    public function update(Request $request, UpdateCategory $updateCategory, int $id)
    {
        $this->authorize('update', Category::class);

        $data = $request->validate([
            'name' => 'required|string|min:3|max:30',
        ]);

        $category = $updateCategory->update($data, $id);

        return response()->json($category);
    }

    public function destroy(DeleteCategory $deleteCategory, int $id)
    {
        $this->authorize('delete', Category::class);

        $category = $deleteCategory->delete($id);

        return response()->json($category);
    }
}
