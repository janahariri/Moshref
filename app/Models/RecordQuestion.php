<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordQuestion extends Model
{
    use HasFactory;

    public function recordAnswers(){
        return $this->hasMany(RecordAnswer::class);
    }

    public function questionsRecordsTypes(){
        return $this->hasMany(QuestionRecordType::class);
    }
}
