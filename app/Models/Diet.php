<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function business()
    {
        return $this->belongsToMany(Business::class, 'rl_business_diets', 'diet_id', 'business_id');
    }

}
