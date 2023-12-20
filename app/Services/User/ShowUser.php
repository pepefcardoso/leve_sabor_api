<?php

namespace App\Services\User;

use App\Models\User;

class ShowUser
{
    public function show($id)
    {
        $user = User::findOrFail($id);

        return $user->load('role', 'userImage')->append('temporary_url_profile_pic');
    }
}