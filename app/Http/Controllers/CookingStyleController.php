<?php

namespace App\Http\Controllers;

use App\Services\CookingStyle\DeleteCookingStyle;
use App\Services\CookingStyle\RegisterCookingStyle;
use App\Services\CookingStyle\SearchCookingStyles;
use App\Services\CookingStyle\ShowCookingStyle;
use App\Services\CookingStyle\UpdateCookingStyle;
use Illuminate\Http\Request;

class CookingStyleController extends Controller
{
    //
    public function index(SearchCookingStyles $searchCookingStyles)
    {
        $cookingStyles = $searchCookingStyles->search();

        return response()->json($cookingStyles);
    }

    public function store(Request $request, RegisterCookingStyle $registerCookingStyle)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:30',
        ]);

        $cookingStyle = $registerCookingStyle->register($request);

        return response()->json($cookingStyle);
    }

    public function show(ShowCookingStyle $showCookingStyle, int $id)
    {
        $cookingStyle = $showCookingStyle->show($id);

        return response()->json($cookingStyle);
    }


    public function update(Request $request, int $id, UpdateCookingStyle $updateCookingStyle)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:30',
        ]);

        $cookingStyle = $updateCookingStyle->update($request, $id);

        return response()->json($cookingStyle);
    }


    public function destroy(int $id, DeleteCookingStyle $deleteCookingStyle)
    {
        $cookingStyle = $deleteCookingStyle->delete($id);

        return response()->json($cookingStyle);
    }
}
