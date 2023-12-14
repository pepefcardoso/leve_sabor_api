<?php

namespace App\Services\Roles;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RegisterRole
{
    public function register(array $data)
    {
        DB::beginTransaction();

        try {
            $role = Role::create($data);

            DB::commit();

            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
