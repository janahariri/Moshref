<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Record extends Model
{
    use HasFactory;

    protected $table = "records";

    public function fieldsupervisor(){
        return $this->belongsTo(User::class, 'id', 'fieldsupervisor_id');
    }
    public function techsupervisor(){
        return $this->belongsTo(User::class, 'id', 'techsupervisor_id');
    }

    public function reportAnswers(){
        return $this->hasMany(ReportAnswer::class);
    }
}
