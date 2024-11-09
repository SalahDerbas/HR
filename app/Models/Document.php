<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory , SoftDeletes;
    protected $table   = "documents";
    protected $guarded = ['id'];

    public function users(){
        return $this->belongsTo(User::class , 'user_id');
    }

    public static function getTableName() {
        return with(new static)->getTable();
    }
    public function getDocumentType(){
        return $this->hasOne(Lookup::class, 'id', 'type_document_id');

    }
}
