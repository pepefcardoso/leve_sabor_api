<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Services\BlogPostImages\DeleteBlogPostImage;
use App\Services\BlogPostImages\RegisterBlogPostImage;
use App\Services\BlogPostImages\SearchBlogPostImages;
use App\Services\BlogPostImages\ShowBlogPostImage;
use App\Services\BlogPostImages\UpdateBlogPostImage;
use Illuminate\Http\Request;

class BlogPostImageController extends Controller
{
    public function index(SearchBlogPostImages $searchBlogPostImages, int $blogPostId)
    {
        $filters = ['blogPostId' => $blogPostId];

        $blogPostImages = $searchBlogPostImages->search($filters);

        return response()->json($blogPostImages);
    }

    public function store(Request $request, RegisterBlogPostImage $registerBlogPostImage, int $blogPostId)
    {
        $this->authorize('create', BlogPost::class);

        $data = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $blogPostImage = $registerBlogPostImage->register($data, $blogPostId);

        return response()->json($blogPostImage);
    }

    public function show(ShowBlogPostImage $showBlogPostImage, int $blogPostId, int $id)
    {
        $blogPostImage = $showBlogPostImage->show($id);

        return response()->json($blogPostImage);
    }

    public function update(Request $request, UpdateBlogPostImage $updateBlogPostImage, int $blogPostId, int $id)
    {
        $this->authorize('update', BlogPost::class);

        $data = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $blogPostImage = $updateBlogPostImage->update($data, $id, $blogPostId);

        return response()->json($blogPostImage);
    }

    public function destroy(DeleteBlogPostImage $deleteBlogPostImage, int $blogPostId, int $id)
    {
        $this->authorize('delete', BlogPost::class);

        $blogPostImage = $deleteBlogPostImage->delete($id);

        return response()->json($blogPostImage);
    }
}
