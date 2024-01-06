<?php

namespace App\Http\Controllers;

use App\Services\Business\FilterBusinesses;
use Illuminate\Http\Request;

class BusinessController
{
    public function index(Request $request, FilterBusinesses $filterBusinesses)
    {
        $filters = $request->validate([
            'name' => 'nullable|string|max:255',
            'category' => 'nullable|array',
            'category.*' => 'nullable|integer|exists:categories,id',
            'diet' => 'nullable|array',
            'diet.*' => 'nullable|integer|exists:diets,id',
            'cooking_style' => 'nullable|array',
            'cooking_style.*' => 'nullable|integer|exists:cooking_styles,id',
            'rating' => 'nullable|integer|between:1,5',
            'distance' => 'nullable|array',
            'distance.latitude' => 'required|numeric|between:-90,90',
            'distance.longitude' => 'required|numeric|between:-180,180',
            'distance.radius' => 'required|integer|min:1',
            'is_open' => 'nullable|boolean',
        ]);

        $businesses = $filterBusinesses->filter($filters);

        return response()->json($businesses);
    }
}
