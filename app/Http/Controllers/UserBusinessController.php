<?php

namespace App\Http\Controllers;

use App\Services\UserBusiness\DeleteUserBusiness;
use App\Services\UserBusiness\RegisterUserBusiness;
use App\Services\UserBusiness\SearchUserBusinesses;
use App\Services\UserBusiness\ShowUserBusiness;
use App\Services\UserBusiness\UpdateUserBusiness;
use Illuminate\Http\Request;

class UserBusinessController extends Controller
{
    public function index(SearchUserBusinesses $searchUserBusinesses, int $userId)
    {
        $filters = ['userId' => $userId];

        $userBusinesses = $searchUserBusinesses->search($filters);

        return response()->json($userBusinesses);
    }

    public function store(Request $request, RegisterUserBusiness $registerUserBusiness, int $userId)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "description" => "nullable|string|max:255",
            "category_id" => "required|integer|exists:categories,id",
            "diets_id" => "nullable|array",
            "diets_id.*" => "nullable|integer|exists:diets,id",
            "address" => "nullable|array",
            "address.street" => "nullable|string|max:255",
            "address.number" => "nullable|string|max:6",
            "address.complement" => "nullable|string|max:255",
            "address.district" => "nullable|string|max:255",
            "address.city" => "nullable|string|max:255",
            "address.state" => "nullable|string|exact:2",
            "address.zip_code" => "required|string|exact:8",
            "address.latitude" => "nullable|string|max:255",
            "address.longitude" => "nullable|string|max:255",
            "contact" => "nullable|array",
            "contact.email" => "nullable|string|max:255",
            "contact.website" => "nullable|string|max:255",
            "contact.facebook" => "nullable|string|max:255",
            "contact.instagram" => "nullable|string|max:255",
            "contact.ifood" => "nullable|string|max:255",
        ]);

        $userBusiness = $registerUserBusiness->register($data, $userId);

        return response()->json($userBusiness);
    }

    public function show(ShowUserBusiness $showUserBusiness, int $userId, int $id)
    {
        $userBusiness = $showUserBusiness->show($id);

        return response()->json($userBusiness);
    }

    public function update(Request $request, UpdateUserBusiness $updateUserBusiness, int $userId, int $id)
    {
        $data = $request->validate([
            "name" => "required|string|max:255",
            "description" => "nullable|string|max:255",
            "category_id" => "required|integer|exists:categories,id",
            "diets_id" => "nullable|array",
            "diets_id.*" => "nullable|integer|exists:diets,id",
            "address" => "nullable|array",
            "address.street" => "nullable|string|max:255",
            "address.number" => "nullable|string|max:6",
            "address.complement" => "nullable|string|max:255",
            "address.district" => "nullable|string|max:255",
            "address.city" => "nullable|string|max:255",
            "address.state" => "nullable|string|exact:2",
            "address.zip_code" => "required|string|exact:8",
            "address.latitude" => "nullable|string|max:255",
            "address.longitude" => "nullable|string|max:255",
            "contact" => "nullable|array",
            "contact.email" => "nullable|string|max:255",
            "contact.website" => "nullable|string|max:255",
            "contact.facebook" => "nullable|string|max:255",
            "contact.instagram" => "nullable|string|max:255",
            "contact.ifood" => "nullable|string|max:255",
        ]);

        $userBusiness = $updateUserBusiness->update($data, $id);

        return response()->json($userBusiness);
    }

    public function destroy(DeleteUserBusiness $deleteUserBusiness, int $userId, int $id)
    {
        $userBusiness = $deleteUserBusiness->delete($id);

        return response()->json($userBusiness);
    }
}
