<?php

namespace App\Http\Controllers;

use App\Services\OpeningHours\DeleteOpeningHours;
use App\Services\OpeningHours\RegisterOpeningHours;
use App\Services\OpeningHours\SearchOpeningHours;
use App\Services\OpeningHours\ShowOpeningHours;
use App\Services\OpeningHours\UpdateOpeningHours;
use Illuminate\Http\Request;

class OpeningHoursController extends Controller
{
    public function index(SearchOpeningHours $searchOpeningHours)
    {
        $openingHours = $searchOpeningHours->search();

        return response()->json($openingHours);
    }

    public function store(Request $request, RegisterOpeningHours $registerOpeningHours)
    {
        $data = $request->validate([
            'specific_date' => 'nullable|date',
            'week_day' => 'required|integer',
            'open_time_1' => 'required|string',
            'close_time_1' => 'required|string',
            'open_time_2' => 'nullable|string',
            'close_time_2' => 'nullable|string',
        ]);

        $openingHours = $registerOpeningHours->register($data);

        return response()->json($openingHours);
    }

    public function show(ShowOpeningHours $showOpeningHours, int $id)
    {
        $openingHours = $showOpeningHours->show($id);

        return response()->json($openingHours);
    }

    public function update(Request $request, UpdateOpeningHours $updateOpeningHours, int $id)
    {
        $data = $request->validate([
            'specific_date' => 'nullable|date',
            'week_day' => 'required|integer',
            'open_time_1' => 'required|string',
            'close_time_1' => 'required|string',
            'open_time_2' => 'nullable|string',
            'close_time_2' => 'nullable|string',
        ]);

        $openingHours = $updateOpeningHours->update($data, $id);

        return response()->json($openingHours);
    }

    public function destroy(DeleteOpeningHours $deleteOpeningHours, int $id)
    {
        $openingHours = $deleteOpeningHours->delete($id);

        return response()->json($openingHours);
    }
}
