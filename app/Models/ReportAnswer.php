<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class ReportAnswer extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

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
