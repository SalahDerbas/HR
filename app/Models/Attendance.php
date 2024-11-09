<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory , SoftDeletes;
    protected $table    = "attendances";
    protected $guarded  = ['id'];

    public static function getTableName() {
        return with(new static)->getTable();
    }

    public function users(){
        return $this->belongsTo(User::class , 'user_id');
    }
    public function getAttendanceStatusType(){
        return $this->hasOne(Lookup::class, 'id', 'status_attendance_id');
    }

}
