<?php

namespace App\Services\Roles;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

class DeleteRole
{
    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $role = Role::findOrFail($id);

            $role->delete();

            DB::commit();

            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
