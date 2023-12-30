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
        'contact_id',
    ];

    static public function rules()
    {
        return [
            'number' => 'required|string|regex:/^\(\d{2}\)\s?\d{4,5}-\d{4}$/',
            'whatsapp' => 'nullable|boolean',
        ];
    }

    static public function businessRules()
    {
        return [
            'contact.phones' => 'nullable|array',
            'contact.phones.*.number' => self::rules()['number'],
            'contact.phones.*.whatsapp' => self::rules()['whatsapp'],
        ];
    }

    static public function contactRules()
    {
        return [
            'phones' => 'nullable|array',
            'phones.*.number' => self::rules()['number'],
            'phones.*.whatsapp' => self::rules()['whatsapp'],
        ];
    }


    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
