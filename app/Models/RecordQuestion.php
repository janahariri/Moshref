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
        return $this->hasMany(RecordAnswer::class);
    }

    public function questionsRecordsTypes(){
        return $this->hasMany(QuestionRecordType::class);
    }
}
