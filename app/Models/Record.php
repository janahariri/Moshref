<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Record extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = "records";
    protected $fillable = [
        'submit_datetime',
        'order_status',
        'fieldsupervisor_id',
        'techsupervisor_id',
        'camp_label',
        'office_number',
    ];


    public function fieldsupervisor(){
        return $this->belongsTo(User::class, 'id', 'fieldsupervisor_id');
    }
    public function techsupervisor(){
        return $this->belongsTo(User::class, 'id', 'techsupervisor_id');
    }

    public function reportAnswers(){
        return $this->hasMany(ReportAnswer::class ,'report_id','id');
    }

    public function recordAnswers(){
        return $this->hasMany(RecordAnswer::class ,'record_id','id');
    }
}
