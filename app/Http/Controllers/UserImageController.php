<?php

namespace App\Http\Controllers;

use App\Services\UserImages\DeleteUserImage;
use App\Services\UserImages\RegisterUserImage;
use App\Services\UserImages\SearchUserImage;
use App\Services\UserImages\ShowUserImage;
use App\Services\UserImages\UpdateUserImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $data = $request->validate([
            'image' => 'required|image',
        ]);

        $userImage = $registerUserImage->register($data, $userId);

        return response()->json($userImage);
    }

    public function show(ShowUserImage $showUserImage, int $id)
    {
        $userImage = $showUserImage->show($id);

        return response()->json($userImage);
    }

    public function update(Request $request, UpdateUserImage $updateUserImage, int $id)
    {
        $data = $request->validate([
            'image' => 'required|image',
        ]);

        $userImage = $updateUserImage->update($data, $id);

        return response()->json($userImage);
    }

    public function destroy(DeleteUserImage $deleteUserImage, int $id)
    {
        $userImage = $deleteUserImage->delete($id);

        return response()->json($userImage);
    }
}
