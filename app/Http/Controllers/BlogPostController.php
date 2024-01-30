<?php

namespace App\Http\Controllers;

use App\Enums\BlogPostStatusEnum;
use App\Models\BlogPost;
use App\Services\BlogPosts\AddToFavorites;
use App\Services\BlogPosts\DeleteBlogPost;
use App\Services\BlogPosts\GetLastBlogPost;
use App\Services\BlogPosts\RegisterBlogPost;
use App\Services\BlogPosts\RemoveFromFavorites;
use App\Services\BlogPosts\SearchBlogPosts;
use App\Services\BlogPosts\ShowBlogPost;
use App\Services\BlogPosts\ShowFavorites;
use App\Services\BlogPosts\UpdateBlogPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BlogPostController extends Controller
{
    public function index(Request $request, SearchBlogPosts $searchBlogPosts): JsonResponse
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'status' => 'nullable|array',
            'status.*' => ['nullable', 'string', Rule::in(BlogPostStatusEnum::cases()),],
        ]);

        $blogPosts = $searchBlogPosts->search($data);

        return response()->json($blogPosts);
    }

    public function show(ShowBlogPost $showBlogPost, int $id): JsonResponse
    {
        $blogPost = $showBlogPost->show($id);

        return response()->json($blogPost);
    }

    public function store(Request $request, RegisterBlogPost $registerBlogPost): JsonResponse
    {
        $this->authorize('create', BlogPost::class);

        $data = $request->validate(BlogPost::rules());

        $blogPost = $registerBlogPost->register($data);

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

    public function getLastPost(GetLastBlogPost $service): JsonResponse
    {
        $blogPost = $service->get();

        return response()->json($blogPost);
    }

    public function addToFavorites(AddToFavorites $service, int $id): JsonResponse
    {
        $response = $service->add($id);

        return response()->json($response);
    }

    public function removeFromFavorites(RemoveFromFavorites $service, int $id): JsonResponse
    {
        $response = $service->remove($id);

        return response()->json($response);
    }

    public function showFavorites(ShowFavorites $service): JsonResponse
    {
        $response = $service->index();

        return response()->json($response);
    }
}
