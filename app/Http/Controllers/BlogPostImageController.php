<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogPostImage;
use App\Services\BlogPostImages\DeleteBlogPostImage;
use App\Services\BlogPostImages\RegisterBlogPostImage;
use App\Services\BlogPostImages\SearchBlogPostImages;
use App\Services\BlogPostImages\ShowBlogPostImage;
use App\Services\BlogPostImages\UpdateBlogPostImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogPostImageController extends Controller
{
    public function index(SearchBlogPostImages $searchBlogPostImages, int $blogPostId): JsonResponse
    {
        $filters = ['blogPostId' => $blogPostId];

        $blogPostImages = $searchBlogPostImages->search($filters);

        return response()->json($blogPostImages);
    }

    public function store(Request $request, RegisterBlogPostImage $registerBlogPostImage, int $blogPostId): JsonResponse
    {
        $this->authorize('create', BlogPost::class);

        $data = $request->validate(BlogPostImage::rules());

        $blogPostImage = $registerBlogPostImage->register($data, $blogPostId);

        return response()->json($blogPostImage);
    }

    public function show(ShowBlogPostImage $showBlogPostImage, int $id): JsonResponse
    {
        $blogPostImage = $showBlogPostImage->show($id);

        return response()->json($blogPostImage);
    }

    public function update(Request $request, UpdateBlogPostImage $updateBlogPostImage, int $blogPostId, int $id): JsonResponse
    {
        $this->authorize('update', BlogPost::class);

        $data = $request->validate(BlogPostImage::rules());

        $blogPostImage = $updateBlogPostImage->update($data, $id, $blogPostId);

        return response()->json($blogPostImage);
    }

    public function destroy(DeleteBlogPostImage $deleteBlogPostImage, int $id): JsonResponse
    {
        $this->authorize('delete', BlogPost::class);

        $blogPostImage = $deleteBlogPostImage->delete($id);

        return response()->json($blogPostImage);
    }
}
