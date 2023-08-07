<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportAnswer extends Model
{
    use HasFactory;

    protected $table = "reports_answers";
    protected $fillable = [
        'question',
        'answers',
        'type',
        'report_id',
    ];



    public function record(){
        return $this->belongsTo(Record::class);

    }
}
