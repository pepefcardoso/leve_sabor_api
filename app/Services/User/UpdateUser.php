<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateUser
{
    public function update(array $data, int $userId)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($userId);

            $user->fill($data);
            $user->save();

            DB::commit();

            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
