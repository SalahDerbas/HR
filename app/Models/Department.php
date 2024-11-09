<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory , SoftDeletes;
    protected $table   = "departments";
    protected $guarded = ['id'];

    public static function getTableName() {
        return with(new static)->getTable();
    }

}
