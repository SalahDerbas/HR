<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissingPunch extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = "missing_punches";
    protected $fillable = [
       'date','time' , 'reason', 'document' ,'user_id' ,'type_missing_punch_id'
    ];

    public function users(){
        return $this->belongsTo(User::class , 'user_id');
    }
}
