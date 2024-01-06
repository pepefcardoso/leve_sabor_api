<?php

namespace App\Services\Business;

use App\Models\Business;
use Carbon\Carbon;

class FilterBusinesses
{
    public function filter(array $filters)
    {
        $query = Business::query();

        foreach ($filters as $key => $value) {
            if ($value !== null) {
                switch ($key) {
                    case 'name':
                        $query->where('name', 'like', '%' . $value . '%');
                        break;
                    case 'is_open':
                        $dayOfWeek = Carbon::now()->dayOfWeek;
                        $currentTime = Carbon::now()->format('H:i:s');

                        $query->whereHas('openingHours', function ($openingHoursQuery) use ($dayOfWeek, $currentTime) {
                            $openingHoursQuery->isOpen($dayOfWeek, $currentTime);
                        });
                        break;
                    case 'diet_ids':
                    case 'category_ids':
                    case 'cooking_style_ids':
                        if (is_array($value) && count($value) > 0) {
                            $query->whereIn($key === 'diet_ids' ? 'diet_id' : ($key === 'category_ids' ? 'category_id' : 'cooking_style_id'), $value);
                        }
                        break;
                    case 'rating':
                        $query->byMinRating($value);
                        break;
                    case 'distance':
                        $latitude = data_get($value, 'latitude');
                        $longitude = data_get($value, 'longitude');
                        $distanceInKm = data_get($value, 'radius');

                        $query->withinDistanceOf($latitude, $longitude, $distanceInKm);

                        break;
                    // Add other cases for new filters if needed
                }
            }
        }

        $count = $query->count();

        $businesses = $query->with(['diet', 'category'])->get();

        $businesses->transform(function ($business) {
            $business->profile_image = $business->logoTemporaryUrl();

            $business->ratings = $business->ratings();

            return $business;
        });

        return [
            'count' => $count,
            'items' => $businesses,
        ];
    }
}
