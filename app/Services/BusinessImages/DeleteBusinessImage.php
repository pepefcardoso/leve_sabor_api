<?php

namespace App\Services\BusinessImages;

use App\Models\BusinessImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteBusinessImage
{
    public function Delete(int $id)
    {
        DB::beginTransaction();

        try {
            $businessImage = BusinessImage::findOrFail($id);

            $businessImage->delete();

            Storage::disk('s3')->delete(BusinessImage::$S3Directory . '/' . $businessImage->name);

            DB::commit();

            return $businessImage;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
