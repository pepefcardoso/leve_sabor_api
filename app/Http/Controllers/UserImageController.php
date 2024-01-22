<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserImage;
use App\Services\UserImages\DeleteUserImage;
use App\Services\UserImages\RegisterUserImage;
use App\Services\UserImages\SearchUserImage;
use App\Services\UserImages\ShowUserImage;
use App\Services\UserImages\UpdateUserImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserImageController extends Controller
{
    public function index(SearchUserImage $searchUserImage, int $userId): JsonResponse
    {
        $filters = ['userId' => $userId];

        $userImages = $searchUserImage->search($filters);

        return response()->json($userImages);
    }

    public function store(Request $request, RegisterUserImage $registerUserImage, int $userId): JsonResponse
    {
        $this->authorize('create', User::class);

        $data = $request->validate(UserImage::rules());

        $userImage = $registerUserImage->register($data, $userId);

        return response()->json($userImage);
    }

    public function show(ShowUserImage $showUserImage, int $id): JsonResponse
    {
        $userImage = $showUserImage->show($id);

        return response()->json($userImage);
    }

    public function update(Request $request, UpdateUserImage $updateUserImage, int $id, int $userId): JsonResponse
    {
        $this->authorize('update', User::class);

        $data = $request->validate(UserImage::rules());

        $userImage = $updateUserImage->update($data, $id, $userId);

        return response()->json($userImage);
    }

    public function destroy(DeleteUserImage $deleteUserImage, int $id): JsonResponse
    {
        $this->authorize('delete', User::class);

        $userImage = $deleteUserImage->delete($id);

        return response()->json($userImage);
    }
}
