<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Services\BlogPosts\DeleteBlogPost;
use App\Services\BlogPosts\RegisterBlogPost;
use App\Services\BlogPosts\SearchBlogPosts;
use App\Services\BlogPosts\ShowBlogPost;
use App\Services\BlogPosts\UpdateBlogPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogPostController extends Controller
{
    public function index(SearchBlogPosts $searchBlogPosts): JsonResponse
    {
        $blogPosts = $searchBlogPosts->search();

        return response()->json($blogPosts);
    }


    public function store(Request $request, RegisterBlogPost $registerBlogPost): JsonResponse
    {
        $this->authorize('create', BlogPost::class);

        $data = $request->validate(BlogPost::rules());

        $blogPost = $registerBlogPost->register($data);

        return response()->json($blogPost);
    }

    public function show(ShowBlogPost $showBlogPost, int $id): JsonResponse
    {
        $blogPost = $showBlogPost->show($id);

        return response()->json($blogPost);
    }

    public function update(Request $request, UpdateBlogPost $updateBlogPost, int $id): JsonResponse
    {
        $this->authorize('update', BlogPost::class);

        $data = $request->validate(BlogPost::rules());

        $blogPost = $updateBlogPost->update($data, $id);

        return response()->json($blogPost);
    }

    public function destroy(DeleteBlogPost $deleteBlogPost, int $id): JsonResponse
    {
        $this->authorize('delete', BlogPost::class);

        $blogPost = $deleteBlogPost->delete($id);

        return response()->json($blogPost);
    }

}
