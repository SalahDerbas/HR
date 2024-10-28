<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lookup extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'code',
        'key',
        'value_ar',
        'value_en',
    ];

    public static function getTableName() {
        return with(new static)->getTable();
    }

}
