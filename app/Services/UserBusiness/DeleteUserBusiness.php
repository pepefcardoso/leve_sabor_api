<?php

namespace App\Services\UserBusiness;

use App\Models\Business;
use Illuminate\Support\Facades\DB;

class DeleteUserBusiness
{
    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $userBusiness = Business::findOrFail($id);

            $userBusiness->delete();

            DB::commit();

            return $userBusiness;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
