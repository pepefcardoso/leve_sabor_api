<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class DeleteUser
{
    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);

            $user->delete();

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
