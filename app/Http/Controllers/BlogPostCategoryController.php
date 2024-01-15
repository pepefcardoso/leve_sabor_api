<?php

namespace App\Http\Controllers;

use App\Models\BlogPostCategory;
use App\Services\BlogPostCategories\DeleteBlogPostCategory;
use App\Services\BlogPostCategories\RegisterBlogPostCategory;
use App\Services\BlogPostCategories\SearchBlogPostCategories;
use App\Services\BlogPostCategories\ShowBlogPostCategory;
use App\Services\BlogPostCategories\UpdateBlogPostCategory;
use Illuminate\Http\Request;

class BlogPostCategoryController extends Controller
{
    public function index(SearchBlogPostCategories $searchBlogPostCategories)
    {
        $categories = $searchBlogPostCategories->search();

        return response()->json($categories);
    }

    public function store(Request $request, RegisterBlogPostCategory $registerBlogPostCategory)
    {
        $this->authorize('create', BlogPostCategory::class);

        $data = $request->validate([
            'name' => 'required|string|min:3|max:30',
        ]);

        $category = $registerBlogPostCategory->register($data);

        return response()->json($category);
    }

    public function show(ShowBlogPostCategory $showBlogPostCategory, int $id)
    {
        $category = $showBlogPostCategory->show($id);

        return response()->json($category);
    }

    public function update(Request $request, UpdateBlogPostCategory $updateBlogPostCategory, int $id)
    {
        $this->authorize('update', BlogPostCategory::class);

        $data = $request->validate([
            'name' => 'required|string|min:3|max:30',
        ]);

        $category = $updateBlogPostCategory->update($data, $id);

        return response()->json($category);
    }

    public function destroy(DeleteBlogPostCategory $deleteBlogPostCategory, int $id)
    {
        $this->authorize('delete', BlogPostCategory::class);

        $blogPostCategory = $deleteBlogPostCategory->delete($id);

        return response()->json($blogPostCategory);
    }
}
