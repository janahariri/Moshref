<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordAnswer extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = "records_answers";
    protected $fillable = [
        'content',
        'question_id',
        'record_id',
    ];


    public function RecordQuestion(){
        return $this->belongsTo(RecordQuestion::class,'question_id','id');
    }
}


