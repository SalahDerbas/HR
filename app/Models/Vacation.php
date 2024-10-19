<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacation extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "vacations";
    protected $fillable = [
       'start_date',
       'end_date',
       'reason',
       'type_vacation_id',
       'user_id',
       'doucument'
    ];

    public function users(){
        return $this->belongsTo(User::class , 'user_id');
    }
}
