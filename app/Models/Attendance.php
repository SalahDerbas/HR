<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = "attendances";
    protected $fillable = [
       'date','time' , 'status_attendance_id', 'location' ,'user_id'
    ];

    public function users(){
        return $this->belongsTo(User::class , 'user_id');
    }

}
