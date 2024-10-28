<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Experince extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = "experinces";
    protected $fillable = [
       'company_name','company_phone','company_location','start_date','end_date','note','leave_reason','document','user_id'
    ];

    public static function getTableName() {
        return with(new static)->getTable();
    }

    public function users(){
        return $this->belongsTo(User::class , 'user_id');
    }

}
