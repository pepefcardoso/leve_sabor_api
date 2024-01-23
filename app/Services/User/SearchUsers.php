<?php

namespace App\Services\User;

use App\Models\User;

class SearchUsers
{
    public function search()
    {
        $users = User::with('role', 'userImage')->get();

        return $users->load( 'userImage');
    }
}
