<?php

namespace App\Http\Controllers;

use App\Services\User\LoginUser;
use App\Services\User\RegisterUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Registration
     */
    public function store(Request $request, RegisterUser $registerUser)
    {
        $data = $request->validate([
            'name' => 'required|min:4',
            'email' => 'required|email',
            'birthday' => 'nullable|date',
            'phone' => 'nullable|string',
            'cpf' => 'nullable|string',
            'password' => 'required|min:8',
        ]);

        $token = $registerUser->register($data);

        return response()->json(['token' => $token], 200);
    }

    /**
     * Login
     */
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
