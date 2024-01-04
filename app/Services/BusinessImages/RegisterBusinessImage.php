<?php

namespace App\Services\BusinessImages;

use App\Models\BusinessImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegisterBusinessImage
{
    public function register(array $data, int $businessId)
    {
        DB::beginTransaction();

        try {
            $image = data_get($data, 'image');

            $type = data_get($data, 'type');

            $imageName = $businessId . '_' . time() . '.' . $image->extension();

            $existingImagesCount = BusinessImage::where('business_id', $businessId)->count();
            throw_if($existingImagesCount >= 10, new \Exception('Business already has 10 images.'));

            if ($type === 'LOGO') {
                $existingLogoCount = BusinessImage::where('business_id', $businessId)
                    ->where('type', 'LOGO')
                    ->count();

                throw_if($existingLogoCount > 0, new \Exception('Business already has a LOGO image.'));
            }

            $path = Storage::disk('s3')->putFileAs('business_images', $image, $imageName);

            $businessImage = BusinessImage::create([
                'business_id' => $businessId,
                'path' => $path,
                'name' => $imageName,
                'type' => $type,
            ]);

            DB::commit();

            return $businessImage;
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }
}
