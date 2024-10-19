<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = "assets";
    protected $fillable = [
       'amount','note' , 'document', 'type_asset_id' ,'user_id'
    ];

    public function users(){
        return $this->belongsTo(User::class , 'user_id');
    }
}
