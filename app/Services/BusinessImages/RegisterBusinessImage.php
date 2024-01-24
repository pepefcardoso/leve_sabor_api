<?php

namespace App\Services\BusinessImages;

use App\Models\BusinessImage;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegisterBusinessImage
{
    public function register(array $data, int $businessId): BusinessImage|string
    {
        DB::beginTransaction();

        try {
            $file = data_get($data, 'file');

            throw_if(!$file, new Exception('File not found'));

            $type = data_get($data, 'type');

            throw_if(!$type, new Exception('Type not found'));

            $name = $businessId . '_' . time() . '.' . $file->extension();

            $existingImagesCount = BusinessImage::where('business_id', $businessId)->count();
            throw_if($existingImagesCount >= 10, new Exception('Business already has 10 images.'));

            if ($type === 'LOGO') {
                $existingLogoCount = BusinessImage::where('business_id', $businessId)
                    ->where('type', 'LOGO')
                    ->count();

                throw_if($existingLogoCount > 0, new Exception('Business already has a LOGO image.'));
            }

            $path = Storage::disk('s3')->putFileAs(BusinessImage::$S3Directory, $file, $name);

            $businessImage = BusinessImage::create([
                'business_id' => $businessId,
                'path' => $path,
                'name' => $name,
                'type' => $type,
            ]);

            DB::commit();

            return $businessImage;
        } catch (Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }
}
