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

    static public function outsideRules()
    {
        return [
            "contact.email" => self::rules()["email"],
            "contact.website" => self::rules()["website"],
            "contact.facebook" => self::rules()["facebook"],
            "contact.instagram" => self::rules()["instagram"],
            "contact.ifood" => self::rules()["ifood"],
        ];
    }

    static public function rules()
    {
        return [
            'email' => 'nullable|email|min:3|max:99',
            'website' => 'nullable|string|min:3|max:99',
            'facebook' => 'nullable|string|min:3|max:99',
            'instagram' => 'nullable|string|min:3|max:99',
            'ifood' => 'nullable|string|min:3|max:99',
        ];
    }

    public function phone()
    {
        return $this->hasMany(Phone::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
