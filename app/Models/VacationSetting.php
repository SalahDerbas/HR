<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VacationSetting extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = "vacation_settings";
    protected $fillable = [
       'name','count'
    ];

    public static function getTableName() {
        return with(new static)->getTable();
    }


}
