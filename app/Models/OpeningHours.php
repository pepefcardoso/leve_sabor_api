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

    static public function rules()
    {
        return [
            "specific_date" => "required_without:week_day|date",
            "week_day" => "required_without:specific_date|integer|between:0,6",
            "open_time_1" => "required|date|date_format:H:i|before:close_time_1",
            "close_time_1" => "required|date|date_format:H:i|after:open_time_1",
            "open_time_2" => "required_if:close_time_2|date|date_format:H:i|before:close_time_2",
            "close_time_2" => "required_if:open_time_2|date|date_format:H:i|after:open_time_2",
        ];
    }

    static public function outsideRules()
    {
        return [
            "opening_hours.specific_date" => "required_without:opening_hours.week_day|date",
            "opening_hours.week_day" => "required_without:opening_hours.specific_date|integer|between:0,6",
            "opening_hours.open_time_1" => "required|date|date_format:H:i|before:close_time_1",
            "opening_hours.close_time_1" => "required|date|date_format:H:i|after:open_time_1",
            "opening_hours.open_time_2" => "required_if:opening_hours.close_time_2|date|date_format:H:i|before:close_time_2",
            "opening_hours.close_time_2" => "required_if:opening_hours.open_time_2|date|date_format:H:i|after:open_time_2",
        ];
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
