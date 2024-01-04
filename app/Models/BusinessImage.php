<?php

namespace App\Models;

use App\Enums\BusinessImageTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class BusinessImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'type',
        'business_id',
    ];

    static public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:99',
            'path' => 'required|string|min:3|max:99',
            'type' => ['nullable', Rule::in(BusinessImageTypeEnum::cases())],
        ];
    }

    static public function businessRules()
    {
        return [
            'images' => 'nullable|array',
            'images.*.file' => 'required|image|max:2048|mimes:jpeg,png,jpg,svg',
            'images.*.type' => ['nullable', Rule::in(BusinessImageTypeEnum::cases())],
        ];
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
