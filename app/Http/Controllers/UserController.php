<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\User\AddFavoriteBusiness;
use App\Services\User\DeleteUser;
use App\Services\User\LoginUser;
use App\Services\User\LogoutUser;
use App\Services\User\RegisterUser;
use App\Services\User\RemoveFavoriteBusiness;
use App\Services\User\SearchUsers;
use App\Services\User\ShowFavoriteBusiness;
use App\Services\User\ShowUser;
use App\Services\User\UpdateUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(SearchUsers $searchUsers)
    {
        $users = $searchUsers->search();

        return response()->json($users);
    }

    public function store(Request $request, RegisterUser $registerUser)
    {
        $data = $request->validate(User::rules());

        $token = $registerUser->register($data);

        return response()->json(['token' => $token], 200);
    }

    public function update(Request $request, UpdateUser $updateUser, int $id)
    {
        $this->authorize('update', User::class);

        $data = $request->validate((User::rules()));

        $user = $updateUser->update($data, $id);

        return response()->json($user);
    }

    public function destroy(DeleteUser $deleteUser, int $id)
    {
        $this->authorize('delete', User::class);

        $user = $deleteUser->delete($id);

        return response()->json($user);
    }

    public function addToFavorites(AddFavoriteBusiness $addFavorite, int $id, int $businessId)
    {
        $this->authorize('update', User::class);

        $response = $addFavorite->add($id, $businessId);

        return response()->json($response);
    }

    public function removeFromFavorites(RemoveFavoriteBusiness $removeFavorite, int $id, int $businessId)
    {
        $this->authorize('update', User::class);

        $response = $removeFavorite->remove($id, $businessId);

        return response()->json($response);
    }

    public function showFavorites(ShowFavoriteBusiness $showFavorite, int $id): JsonResponse
    {
        $this->authorize('view', User::class);

        $response = $showFavorite->show($id);

        return response()->json($response);
    }

    public function show(ShowUser $showUser, int $id)
    {
        $this->authorize('view', User::class);

        $user = $showUser->show($id);

        return response()->json($user);
    }

    public function login(Request $request, LoginUser $loginUser)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $result = $loginUser->login($data);

        if (isset($result['token'])) {
            return response()->json(['token' => $result['token']], 200);
        } else {
            return response()->json(['error' => $result['error']], 422);
        }
    }

    public function logout(LogoutUser $logoutUser)
    {
        $response = $logoutUser->logout();

        return response()->json($response);
    }

    public function loggedUserData()
    {
        $user = auth()->user();

        $user->append('temporary_url_profile_pic');

        return response()->json($user);
    }
}
