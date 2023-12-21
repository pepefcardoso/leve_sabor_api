<?php

namespace App\Services\UserBusiness;

use App\Models\Business;

class ShowUserBusiness
{
    public function show($id)
    {
        $userBusiness = Business::findOrfail($id);

        return $userBusiness->load('category', 'user', 'diet', 'address', 'contact');
    }
}
