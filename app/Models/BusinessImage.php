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
            'id' => 'nullable|integer|exists:business_images,id',
            'file' => 'nullable',
            'type' => ['nullable', Rule::in(BusinessImageTypeEnum::cases())],
        ];
    }

    static public function businessRules()
    {
        return [
            'images' => 'nullable|array',
            'images.*.id' => 'nullable|integer|exists:business_images,id',
            'images.*.file' => 'nullable',
            'images.*.type' => ['required', Rule::in(BusinessImageTypeEnum::cases())],
        ];
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
