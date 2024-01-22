<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessImage;
use App\Services\BusinessImages\DeleteBusinessImage;
use App\Services\BusinessImages\RegisterBusinessImage;
use App\Services\BusinessImages\SearchBusinessImage;
use App\Services\BusinessImages\ShowBusinessImage;
use App\Services\BusinessImages\UpdateBusinessImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BusinessImageController extends Controller
{
    public function index(SearchBusinessImage $searchBusinessImage, int $businessId): JsonResponse
    {
        $filters = ['businessId' => $businessId];

        $businessImages = $searchBusinessImage->search($filters);

        return response()->json($businessImages);
    }

    public function store(Request $request, RegisterBusinessImage $registerBusinessImage, int $businessId): JsonResponse
    {
        $this->authorize('create', Business::class);

        $data = $request->validate(BusinessImage::rules());

        $businessImage = $registerBusinessImage->register($data, $businessId);

        return response()->json($businessImage);
    }

    public function show(ShowBusinessImage $showBusinessImage, int $id): JsonResponse
    {
        $businessImage = $showBusinessImage->show($id);

        return response()->json($businessImage);
    }

    public function update(Request $request, UpdateBusinessImage $updateBusinessImage, int $id, int $businessId): JsonResponse
    {
        $this->authorize('update', Business::class);

        $data = $request->validate(BusinessImage::rules());

        $businessImage = $updateBusinessImage->update($data, $id, $businessId);

        return response()->json($businessImage);
    }

    public function destroy(DeleteBusinessImage $deleteBusinessImage, int $id): JsonResponse
    {
        $this->authorize('delete', Business::class);

        $businessImage = $deleteBusinessImage->delete($id);

        return response()->json($businessImage);
    }
}
