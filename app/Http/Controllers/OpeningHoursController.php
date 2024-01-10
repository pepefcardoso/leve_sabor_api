<?php

namespace App\Http\Controllers;

use App\Models\OpeningHours;
use App\Services\OpeningHours\DeleteOpeningHours;
use App\Services\OpeningHours\RegisterOpeningHours;
use App\Services\OpeningHours\SearchOpeningHours;
use App\Services\OpeningHours\ShowOpeningHours;
use App\Services\OpeningHours\UpdateOpeningHours;
use Illuminate\Http\Request;

class OpeningHoursController extends Controller
{
    public function index(SearchOpeningHours $searchOpeningHours, int $businessId)
    {
        $filters = ['businessId' => $businessId];

        $openingHours = $searchOpeningHours->search($filters);

        return response()->json($openingHours);
    }

    public function store(Request $request, RegisterOpeningHours $registerOpeningHours, int $businessId)
    {
        $data = $request->validate(OpeningHours::rules());

        $openingHours = $registerOpeningHours->register($data, $businessId);

        return response()->json($openingHours);
    }

    public function show(ShowOpeningHours $showOpeningHours, int $businessId, int $id)
    {
        $openingHours = $showOpeningHours->show($id);

        return response()->json($openingHours);
    }

    public function update(Request $request, UpdateOpeningHours $updateOpeningHours, int $businessId, int $id)
    {
        $this->authorize('update', OpeningHours::class);

        $data = $request->validate(OpeningHours::rules());

        $openingHours = $updateOpeningHours->update($data, $id);

        return response()->json($openingHours);
    }

    public function destroy(DeleteOpeningHours $deleteOpeningHours, int $businessId, int $id)
    {
        $this->authorize('delete', OpeningHours::class);

        $openingHours = $deleteOpeningHours->delete($id);

        return response()->json($openingHours);
    }
}
