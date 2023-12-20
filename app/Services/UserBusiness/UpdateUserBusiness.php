<?php

namespace App\Services\UserBusiness;

use App\Models\Business;
use Illuminate\Support\Facades\DB;

class UpdateUserBusiness
{
    public function update(array $data, int $id)
    {
        DB::beginTransaction();

        try {
            $userBusiness = Business::findOrFail($id);

            $userBusiness->fill($data);
            $userBusiness->save();

            DB::commit();

            return $userBusiness;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
