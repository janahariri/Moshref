<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class QuestionsRecordsTypes extends Model
{

    use HasApiTokens, HasFactory;

    protected $table = "questions_records_types";
    protected $fillable = [
        'typeName',

    ];

    use HasFactory;
    public function recordQuestion(){
        return $this->hasMany(RecordQuestion::class,'typeName','type_id');
    }
}
