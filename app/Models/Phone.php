<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'whatsapp',
    ];

    public function contact()
    {
        return $this->belongsTo(Contacts::class);
    }
}
