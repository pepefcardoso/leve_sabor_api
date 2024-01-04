<?php

namespace App\Http\Controllers;

use App\Models\BusinessImage;
use App\Services\BusinessImages\DeleteBusinessImage;
use App\Services\BusinessImages\RegisterBusinessImage;
use App\Services\BusinessImages\SearchBusinessImage;
use App\Services\BusinessImages\ShowBusinessImage;
use App\Services\BusinessImages\UpdateBusinessImage;
use Illuminate\Http\Request;

class BusinessImageController extends Controller
{
    public function index(SearchBusinessImage $searchBusinessImage, int $businessId)
    {
        $filters = ['businessId' => $businessId];

        $businessImages = $searchBusinessImage->search($filters);

        return response()->json($businessImages);
    }

    public function store(Request $request, RegisterBusinessImage $registerBusinessImage, int $businessId)
    {
        $data = $request->validate(BusinessImage::rules());

        $businessImage = $registerBusinessImage->register($data, $businessId);

        return response()->json($businessImage);
    }

    public function show(ShowBusinessImage $showBusinessImage, int $businessId, int $id)
    {
        $businessImage = $showBusinessImage->show($id);

        return response()->json($businessImage);
    }

    public function update(Request $request, UpdateBusinessImage $updateBusinessImage, int $id, int $businessId)
    {
        $data = $request->validate(BusinessImage::rules());

        $businessImage = $updateBusinessImage->update($data, $id, $businessId);

        return response()->json($businessImage);
    }

    public function destroy(DeleteBusinessImage $deleteBusinessImage, int $businessId, int $id)
    {
        $businessImage = $deleteBusinessImage->delete($id);

        return response()->json($businessImage);
    }
}
