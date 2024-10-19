<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pushnotification extends Model
{
    use HasFactory , SoftDeletes;

    protected $guarded = ['id'];

    public function users(){
        return $this->belongsTo(User::class , 'user_id');
    }


}
