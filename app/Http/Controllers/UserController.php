<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\User\DeleteUser;
use App\Services\User\LoginUser;
use App\Services\User\RegisterUser;
use App\Services\User\SearchUsers;
use App\Services\User\ShowUser;
use App\Services\User\UpdateUser;
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

    public function show(ShowUser $showUser, int $id)
    {
        $user = $showUser->show($id);

        return response()->json($user);
    }

    public function update(Request $request, UpdateUser $updateUser, int $id)
    {
        $data = $request->validate((User::rules()));

        $user = $updateUser->update($data, $id);

        return response()->json($user);
    }

    public function destroy(DeleteUser $deleteUser, int $id)
    {
        $user = $deleteUser->delete($id);

        return response()->json($user);
    }

    public function login(Request $request, LoginUser $loginUser)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $token = $loginUser->login($data);

        if ($token) {
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
