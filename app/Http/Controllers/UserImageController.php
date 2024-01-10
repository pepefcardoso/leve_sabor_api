<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserImages\DeleteUserImage;
use App\Services\UserImages\RegisterUserImage;
use App\Services\UserImages\SearchUserImage;
use App\Services\UserImages\ShowUserImage;
use App\Services\UserImages\UpdateUserImage;
use Illuminate\Http\Request;

class UserImageController extends Controller
{
    public function index(SearchUserImage $searchUserImage, int $userId)
    {
        $filters = ['userId' => $userId];

        $userImages = $searchUserImage->search($filters);

        return response()->json($userImages);
    }

    public function store(Request $request, RegisterUserImage $registerUserImage, int $userId)
    {
        $this->authorize('create', User::class);

        $data = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $userImage = $registerUserImage->register($data, $userId);

        return response()->json($userImage);
    }

    public function show(ShowUserImage $showUserImage, int $UserId, int $id)
    {
        $userImage = $showUserImage->show($id);

        return response()->json($userImage);
    }

    public function update(Request $request, UpdateUserImage $updateUserImage, int $id, int $userId)
    {
        $this->authorize('update', User::class);

        $data = $request->validate([
            'image' => 'required|image',
        ]);

        $userImage = $updateUserImage->update($data, $id, $userId);

        return response()->json($userImage);
    }

    public function destroy(DeleteUserImage $deleteUserImage, int $userId, int $id)
    {
        $this->authorize('delete', User::class);

        $userImage = $deleteUserImage->delete($id);

        return response()->json($userImage);
    }
}
