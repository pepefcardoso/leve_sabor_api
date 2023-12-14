<?php

namespace App\Services\Roles;

use App\Models\Role;

class ShowRole
{
    public function show(int $id)
    {
        $role = Role::findOrfail($id);

        return $role;
    }
}
