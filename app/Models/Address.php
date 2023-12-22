<?php

namespace App\Models;

use App\Enums\StatesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'zip_code',
        'latitude',
        'longitude',
        'business_id',
    ];

    static public function outsideRules()
    {
        return [
            "address.street" => self::rules()["street"],
            "address.number" => self::rules()["number"],
            "address.complement" => self::rules()["complement"],
            "address.district" => self::rules()["district"],
            "address.city" => self::rules()["city"],
            "address.state" => self::rules()["state"],
            "address.zip_code" => self::rules()["zip_code"],
            "address.latitude" => self::rules()["latitude"],
            "address.longitude" => self::rules()["longitude"]
        ];
    }

    static public function rules()
    {
        return [
            'street' => 'nullable|string|min:3|max:99',
            'number' => 'nullable|string|min:1|max:10',
            'complement' => 'nullable|string|min:3|max:99',
            'district' => 'nullable|string|min:3|max:99',
            'city' => 'nullable|string|min:3|max:99',
            'state' => ['nullable', Rule::in(StatesEnum::cases())],
            'zip_code' => 'required|string|size:9|regex:/^\d{2}\.?\d{3}-\d{3}$/',
            'latitude' => 'nullable|numeric|between:-180,180|required_with:longitude',
            'longitude' => 'nullable|numeric|between:-180,180|required_with:latitude',
        ];
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
