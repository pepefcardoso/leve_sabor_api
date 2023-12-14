<?php

namespace App\Services\Roles;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

class UpdateRole
{
    public function update(array $data, int $id)
    {
        DB::beginTransaction();

        try {
            $role = Role::findOrFail($id);

            $role->fill($data);
            $role->save();

            DB::commit();

            return $role;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
