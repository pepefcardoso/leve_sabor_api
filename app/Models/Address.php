<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
