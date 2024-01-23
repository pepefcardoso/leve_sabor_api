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

                        $query->isOpen($dayOfWeek, $currentTime);
                        break;
                    case 'diet':
                        $query->whereHas('diet', function ($dietQuery) use ($value) {
                            $table = $dietQuery->getModel()->getTable();
                            $dietQuery->whereIn($table . '.id', $value);
                        });
                        break;
                    case 'category':
                        $query->whereHas('category', function ($categoryQuery) use ($value) {
                            $table = $categoryQuery->getModel()->getTable();
                            $categoryQuery->whereIn($table . '.id', $value);
                        });
                        break;
                    case 'cooking_style':
                        $query->whereHas('cookingStyle', function ($cookingStyleQuery) use ($value) {
                            $table = $cookingStyleQuery->getModel()->getTable();
                            $cookingStyleQuery->whereIn($table . '.id', $value);
                        });
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
                }
            }
        }

        $count = $query->count();

        $businesses = $query->with(['mainDiet', 'category', 'logo'])->get();

        $businesses->transform(function ($business) {
            $business->ratings = $business->ratings();

            return $business;
        });

        return [
            'count' => $count,
            'items' => $businesses,
        ];
    }
}
