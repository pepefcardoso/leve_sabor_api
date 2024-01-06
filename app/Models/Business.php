<?php

namespace App\Models;

use App\Services\BusinessImages\TemporaryUrlBusinessImage;
use App\Services\Reviews\ShowReviewsRating;
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

    static public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:99|unique:businesses,name',
            'description' => 'nullable|string|max:255',
            "category_id" => "required|integer|exists:categories,id",
            "diets_id" => "required|array",
            "diets_id.*" => "nullable|integer|exists:diets,id",
            "address" => "nullable|array",
            ...Address::outsideRules(),
            "contact" => "nullable|array",
            ...Contact::outsideRules(),
            ...Phone::businessRules(),
            "opening_hours" => "nullable|array",
            ...OpeningHours::outsideRules(),
            "cooking_styles_ids" => "required|array",
            "cooking_styles_ids.*" => "nullable|integer|exists:cooking_styles,id",
            ...BusinessImage::businessRules(),
        ];
    }

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

    public function review()
    {
        return $this->hasMany(Review::class);
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

    public function logoTemporaryUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                $businessImage = $this->businessImage()->where('type', 'LOGO')->first();

                if ($businessImage) {
                    $temporaryUrlBusinessImage = app(TemporaryUrlBusinessImage::class);

                    return $temporaryUrlBusinessImage->temporaryUrl($businessImage);
                }

                return null;
            }
        );
    }

    public function ratings(): Attribute
    {
        return Attribute::make(
            get: function () {
                $ratings = app(ShowReviewsRating::class);

                return $ratings->show($this->id);
            }
        );
    }

    public function scopeByMinRating($query, $minRating)
    {
        return $query->leftJoin('reviews', 'businesses.id', '=', 'reviews.business_id')
            ->selectRaw('businesses.*, IFNULL(AVG(reviews.rating), 0) AS avg_rating')
            ->groupBy('businesses.id')
            ->havingRaw('avg_rating >= ?', [$minRating]);
    }

    public function scopeIsOpen($query, $day, $time)
    {
        return $query->where('week_day', $day)
            ->where(function ($query) use ($time) {
                $query->where(function ($q) use ($time) {
                    $q->where('open_time_1', '<=', $time)
                        ->where('close_time_1', '>=', $time);
                })->orWhere(function ($q) use ($time) {
                    $q->where('open_time_2', '<=', $time)
                        ->where('close_time_2', '>=', $time);
                });
            });
    }

    public function scopeWithinDistanceOf($query, $latitude, $longitude, $distanceInKm)
    {
        return $query->whereHas('address', function ($addressQuery) use ($latitude, $longitude, $distanceInKm) {
            $addressQuery->selectRaw('*,
                ( 6371 * ACOS( COS( RADIANS(?) ) * COS( RADIANS( latitude ) ) * COS( RADIANS( longitude ) - RADIANS(?) ) + SIN( RADIANS(?) ) * SIN( RADIANS( latitude ) ) ) ) AS distance', [
                $latitude,
                $longitude,
                $latitude
            ])
                ->havingRaw('distance <= ?', [$distanceInKm]);
        });
    }
}
