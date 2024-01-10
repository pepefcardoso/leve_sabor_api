<?php

namespace App\Http\Controllers;

use App\Models\CookingStyle;
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
        $this->authorize('create', CookingStyle::class);

        $data = $request->validate([
            'name' => 'required|string|min:3|max:30',
        ]);

        $cookingStyle = $registerCookingStyle->register($data);

        return response()->json($cookingStyle);
    }

    public function show(ShowCookingStyle $showCookingStyle, int $id)
    {
        $cookingStyle = $showCookingStyle->show($id);

        return response()->json($cookingStyle);
    }


    public function update(Request $request, UpdateCookingStyle $updateCookingStyle, int $id)
    {
        $this->authorize('update', CookingStyle::class);

        $data = $request->validate([
            'name' => 'required|string|min:3|max:30',
        ]);

        $cookingStyle = $updateCookingStyle->update($data, $id);

        return response()->json($cookingStyle);
    }


    public function destroy(DeleteCookingStyle $deleteCookingStyle, int $id)
    {
        $this->authorize('delete', CookingStyle::class);

        $cookingStyle = $deleteCookingStyle->delete($id);

        return response()->json($cookingStyle);
    }
}
