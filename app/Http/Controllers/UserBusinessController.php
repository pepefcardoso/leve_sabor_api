<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Contact;
use App\Models\OpeningHours;
use App\Models\Phone;
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
            "diets_id" => "required|array",
            "diets_id.*" => "nullable|integer|exists:diets,id",
            "address" => "nullable|array",
            ...Address::outsideRules(),
            "contact" => "nullable|array",
            ...Contact::outsideRules(),
            ...Phone::businessRules(),
            "opening_hours" => "nullable|array",
            ...OpeningHours::outsideRules(),
            "cooking_styles_ids" => "required|array",
            "cooking_styles_ids.*" => "nullable|integer|exists:cooking_styles,id",
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
            ...Address::outsideRules(),
            "contact" => "nullable|array",
            ...Contact::outsideRules(),
            ...Phone::businessRules(),
            "opening_hours" => "nullable|array",
            ...OpeningHours::outsideRules(),
            "cooking_styles_ids" => "nullable|array",
            "cooking_styles_ids.*" => "nullable|integer|exists:cooking_styles,id",
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
