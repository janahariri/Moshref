<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class RecordQuestion extends Model
{
    use HasApiTokens, HasFactory;


    protected $table = "records_questions";
    protected $fillable = [
        'content',
        'type_id',
    ];


    public function recordAnswers(){
        return $this->hasMany(RecordAnswer::class,'id','question_id');
    }
    public function questionsRecordsTypes(){
        return $this->belongsTo(QuestionsRecordsTypes::class,'type_id','id');
    }
}
