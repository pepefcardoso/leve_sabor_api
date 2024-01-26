<?php

namespace App\Services\UserBusiness;

use App\Models\Business;
use App\Services\BusinessImages\DeleteBusinessImage;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeleteUserBusiness
{
    private DeleteBusinessImage $deleteBusinessImage;

    public function __construct(DeleteBusinessImage $deleteBusinessImage)
    {
        $this->deleteBusinessImage = $deleteBusinessImage;
    }

    public function delete(int $id): Business|Exception|string
    {
        DB::beginTransaction();

        try {
            $userBusiness = Business::with('address')->findOrFail($id);

            $userBusiness->diet()->detach();

            $userBusiness->cookingStyle()->detach();

            $businessImage = $userBusiness->businessImage;

            if ($businessImage) {
                foreach ($businessImage as $image) {
                    $response = $this->deleteBusinessImage->delete($image->id);
                    throw_if(is_string($response), Exception::class, $response);
                }
            }

            $userBusiness->delete();

            DB::commit();

            return $userBusiness;
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        } catch (Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
