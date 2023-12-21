<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'website',
        'facebook',
        'instagram',
        'ifood',
        'business_id',
    ];

    public function phone()
    {
        return $this->hasMany(Phone::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
