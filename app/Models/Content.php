<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'title_en',
        'title_ar',
        'description_en',
        'description_ar',
        'photo',
        'status',
        'type_id',
    ];

    public static function getTableName() {
        return with(new static)->getTable();
    }

}
