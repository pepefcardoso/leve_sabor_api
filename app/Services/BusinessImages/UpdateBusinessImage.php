<?php

namespace App\Services\BusinessImages;

use App\Models\BusinessImage;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateBusinessImage
{
    public function update(array $data, int $id, int $businessId): BusinessImage|string
    {
        DB::beginTransaction();

        try {
            $businessImage = BusinessImage::findOrFail($id);

            $newFile = data_get($data, 'file');
            throw_if(!$newFile, new Exception('File not found'));

            $newType = data_get($data, 'type');
            throw_if(!$newType, new Exception('Type not found'));

            $newName = $businessId . '_' . time() . '.' . $newFile->extension();

            $existingImagesCount = BusinessImage::where('business_id', $businessId)->count();
            throw_if($existingImagesCount >= 10, new Exception('Business already has 10 images.'));

            if ($newType === 'LOGO') {
                $existingLogoCount = BusinessImage::where('business_id', $businessId)
                    ->where('type', 'LOGO')
                    ->count();

                throw_if($existingLogoCount > 0, new Exception('Business already has a LOGO image.'));
            }

            $path = Storage::disk('s3')->putFileAs(BusinessImage::$S3Directory, $newFile, $newName);

            if ($path) {
                Storage::disk('s3')->delete(BusinessImage::$S3Directory . '/' . $businessImage->name);
            } else {
                throw new Exception('Error uploading image.');
            }

            $businessImage = BusinessImage::fill([
                'business_id' => $businessId,
                'path' => $path,
                'name' => $newName,
                'type' => $newType,
            ]);

            $businessImage->save();

            DB::commit();

            return $businessImage;
        } catch (Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }
}
