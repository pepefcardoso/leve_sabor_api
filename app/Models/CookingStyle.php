<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CookingStyle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function business()
    {
        return $this->belongsToMany(Business::class, 'rl_business_cooking_styles', 'cooking_style_id', 'business_id');
    }
}
