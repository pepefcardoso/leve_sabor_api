<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    use HasFactory;

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
}
