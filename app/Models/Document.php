<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = "documents";
    protected $fillable = [
       'document','note' , 'type_document_id' ,'user_id'
    ];

    public function users(){
        return $this->belongsTo(User::class , 'user_id');
    }

    public static function getTableName() {
        return with(new static)->getTable();
    }
}
