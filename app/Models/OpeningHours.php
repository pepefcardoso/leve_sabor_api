<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpeningHours extends Model
{
    use HasFactory;

    protected $fillable = [
        'specific_date',
        'week_day',
        'open_time_1',
        'close_time_1',
        'open_time_2',
        'close_time_2',
        'business_id',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
