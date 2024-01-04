<?php

namespace App\Models;

use App\Services\BusinessImages\TemporaryUrlBusinessImage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'category_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function diet()
    {
        return $this->belongsToMany(Diet::class, 'rl_business_diets', 'business_id', 'diet_id');
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function contact()
    {
        return $this->hasOne(Contact::class);
    }

    public function openingHours()
    {
        return $this->hasMany(OpeningHours::class);
    }

    public function cookingStyle()
    {
        return $this->belongsToMany(CookingStyle::class, 'rl_business_cooking_styles', 'business_id', 'cooking_style_id');
    }

    public function businessImage()
    {
        return $this->hasMany(BusinessImage::class);
    }

    public function imageTemporaryUrl(int $imageId): Attribute
    {
        return Attribute::make(
            get: function () use ($imageId) {
                $businessImage = $this->businessImage()->find($imageId);

                if ($businessImage) {
                    $temporaryUrlBusinessImage = app(TemporaryUrlBusinessImage::class);

                    return $temporaryUrlBusinessImage->temporaryUrl($businessImage);
                }

                return null;
            }
        );
    }
}
