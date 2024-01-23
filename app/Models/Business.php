<?php

namespace App\Models;

use App\Enums\BusinessImageTypeEnum;
use App\Services\Reviews\ShowReviewsRating;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'category_id',
        'main_diet_id',
    ];

    public static function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:99|unique:businesses,name',
            'description' => 'nullable|string|max:255',
            "category_id" => "required|integer|exists:categories,id",
            "diets_id" => "required|array",
            "diets_id.*" => "nullable|integer|exists:diets,id",
            "main_diet_id" => "required|integer|exists:diets,id",
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

    public function review()
    {
        return $this->hasMany(Review::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'rl_user_favorite_businesses', 'business_id', 'user_id');
    }

    public function mainDiet()
    {
        return $this->belongsTo(Diet::class, 'main_diet_id');
    }

    public function businessImage()
    {
        return $this->hasMany(BusinessImage::class);
    }

    public function logo()
    {
        return $this->hasOne(BusinessImage::class)->where('type', BusinessImageTypeEnum::LOGO);
    }

    public function coverImages()
    {
        return $this->hasMany(BusinessImage::class)->where('type', BusinessImageTypeEnum::COVER);
    }

    public function ratings(): Attribute
    {
        return Attribute::make(
            get: function () {
                return app(ShowReviewsRating::class)->show($this->id);
            }
        );
    }

    public function isOpenNow(): Attribute
    {
        return Attribute::make(
            get: function () {
                $now = Carbon::now();
                $dayOfWeek = $now->dayOfWeek;
                $currentTime = $now->format('H:i:s');

                return (bool)$this->openingHours->first(function ($openingHour) use ($dayOfWeek, $currentTime) {
                    if ($openingHour->week_day === $dayOfWeek) {
                        if ($currentTime >= $openingHour->open_time_1 && $currentTime <= $openingHour->close_time_1) {
                            return true;
                        }

                        if ($openingHour->open_time_2 && $currentTime >= $openingHour->open_time_2 && $currentTime <= $openingHour->close_time_2) {
                            return true;
                        }
                    }

                    return false;
                });
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
        return $query->whereHas('openingHours', function ($q) use ($day, $time) {
            $q->where('week_day', $day)
                ->where(function ($q) use ($time) {
                    $q->where(function ($subQuery) use ($time) {
                        $subQuery->where('open_time_1', '<=', $time)
                            ->where('close_time_1', '>=', $time);
                    })->orWhere(function ($subQuery) use ($time) {
                        $subQuery->where('open_time_2', '<=', $time)
                            ->where('close_time_2', '>=', $time);
                    });
                });
        });
    }


    public function scopeWithinDistanceOf($query, $latitude, $longitude, $distanceInKm)
    {
        $earthRadius = 6371; // Earth's radius in kilometers

        return $query->whereExists(function ($subQuery) use ($latitude, $longitude, $distanceInKm, $earthRadius) {
            $subQuery->select(DB::raw(1))
                ->from('addresses')
                ->whereColumn('businesses.id', 'addresses.business_id')
                ->whereRaw("
                    (
                        ? * ATAN2(
                            SQRT(
                                POW(COS(RADIANS(addresses.latitude)) * SIN(RADIANS(addresses.longitude - ?)), 2) +
                                POW(COS(RADIANS(?)) * SIN(RADIANS(addresses.latitude)) - SIN(RADIANS(?)) * COS(RADIANS(addresses.latitude)) * COS(RADIANS(addresses.longitude - ?)), 2)
                            ),
                            SIN(RADIANS(?)) * SIN(RADIANS(addresses.latitude)) + COS(RADIANS(?)) * COS(RADIANS(addresses.latitude)) * COS(RADIANS(addresses.longitude - ?))
                        )
                    ) <= ?",
                    [$earthRadius, $longitude, $latitude, $latitude, $longitude, $latitude, $latitude, $longitude, $distanceInKm]
                );
        });
    }

}
