<?php

namespace App\Services\Roles;

use App\Models\Role;

class SearchRoles
{
    public function search()
    {
        $roles = Role::all();

        return $roles;
    }
}
