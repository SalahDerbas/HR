<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = "settings";
    protected $fillable = [
        'company_name',
        'created_date',
        'company_location',
        'company_phone',
        'owner',
        'website_url',
        'logo',
        'holiday_days',
        'note'
    ];


}
