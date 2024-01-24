<?php

namespace App\Models;

use App\Services\UserImages\TemporaryUrlUserImage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    use HasFactory;

    static public string $S3Directory = 'user_images';
    protected $appends = [
        'url',
    ];

    protected $fillable = [
        'name',
        'path',
        'user_id',
    ];

    static public function rules()
    {
        return [
            'id' => 'nullable|integer|exists:user_images,id',
            'file' => 'nullable',
        ];
    }

    static public function userRules()
    {
        return [
            'image' => 'nullable|array',
            'image.id' => 'nullable|integer|exists:user_images,id',
            'image.file' => 'nullable',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function url(): Attribute
    {
        return Attribute::make(
            fn() => (new TemporaryUrlUserImage())->temporaryUrl($this)
        );
    }
}
