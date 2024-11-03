<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "leaves";
    protected $fillable = [
       'start_time','end_time','reason_leave_id','status_leave_id','user_id','doucument'
    ];

    public static function getTableName() {
        return with(new static)->getTable();
    }

    public function users(){
        return $this->belongsTo(User::class , 'user_id');
    }

    public function getReasonLeave(){
        return $this->hasOne(Lookup::class, 'id', 'reason_leave_id');
    }

    public function getStatusLeave(){
        return $this->hasOne(Lookup::class, 'id', 'status_leave_id');
    }

}
