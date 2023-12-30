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
            "specific_date" => "required_without:week_day|nullable|date",
            "week_day" => "required_without:specific_date|nullable|integer|between:0,6",
            "open_time_1" => "required|date_format:H:i",
            "close_time_1" => "required|date_format:H:i|after:open_time_1",
            "open_time_2" => "nullable|required_with:close_time_2|date_format:H:i|after:close_time_1",
            "close_time_2" => "nullable|required_with:open_time_2|date_format:H:i|after:open_time_2",
        ];
    }

    static public function outsideRules()
    {
        return [
            "opening_hours" => "nullable|array",
            "opening_hours.*.specific_date" => "required_without:opening_hours.*.week_day|nullable|date",
            "opening_hours.*.week_day" => "required_without:opening_hours.*.specific_date|nullable|integer|between:0,6",
            "opening_hours.*.open_time_1" => "required|date_format:H:i",
            "opening_hours.*.close_time_1" => "required|date_format:H:i|after:opening_hours.*.open_time_1",
            "opening_hours.*.open_time_2" => "nullable|required_with:opening_hours.*.close_time_2|date_format:H:i|after:opening_hours.*.close_time_1",
            "opening_hours.*.close_time_2" => "nullable|required_with:opening_hours.*.open_time_2|date_format:H:i|after:opening_hours.*.open_time_2",
        ];
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
