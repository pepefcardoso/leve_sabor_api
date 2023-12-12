<?php

namespace App\Http\Controllers;

use App\Services\Diets\DeleteDiet;
use App\Services\Diets\RegisterDiet;
use App\Services\Diets\SearchDiets;
use App\Services\Diets\ShowDiet;
use App\Services\Diets\UpdateDiet;
use Illuminate\Http\Request;

class DietController extends Controller
{
    //
    public function index(SearchDiets $searchDiets)
    {
        $diets = $searchDiets->search();

        return response()->json($diets);
    }

    public function store(Request $request, RegisterDiet $registerDiet)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:30',
        ]);

        $diet = $registerDiet->register($request);

        return response()->json($diet);
    }

    public function show(ShowDiet $showDiet, int $id)
    {
        $diet = $showDiet->show($id);

        return response()->json($diet);
    }

    public function update(Request $request, int $id, UpdateDiet $updateDiet)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:30',
        ]);

        $diet = $updateDiet->update($request, $id);

        return response()->json($diet);
    }

    public function destroy(int $id, DeleteDiet $deleteDiet)
    {
        $diet = $deleteDiet->delete($id);

        return response()->json($diet);
    }

}
