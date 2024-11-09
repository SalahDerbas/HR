<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory , SoftDeletes;
    protected $table   = "events";
    protected $guarded = ['id'];

    public static function getTableName() {
        return with(new static)->getTable();
    }

}
