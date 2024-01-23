<?php

namespace App\Services\UserBusiness;

use App\Models\Business;

class SearchUserBusinesses
{
    public function search($filters)
    {
        $userBusinesses = Business::where('user_id', $filters['userId'])
            ->get();

        $userBusinesses->transform(function ($business) {
            $business->ratings = $business->ratings();

            return $business;
        });

        return $userBusinesses->load('category', 'user', 'diet', 'address', 'contact', 'openingHours', 'cookingStyle', 'logo', 'coverImages');
    }
}
