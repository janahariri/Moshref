<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class TechFieldsLookup extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table ="tech_fields_lookup";
    protected $fillable = [
        'techsupervisor_id',
        'fieldsupervisor_id',
    ];


    public function Fieldsupervisor_records(){
        return $this->hasMany(Record::class,'fieldsupervisor_id', 'id');
    }
    public function Techsupervisor_records(){
        return $this->hasMany(Record::class,'techsupervisor_id','id');
    }

    public function Techsupervisor_id_users(){
        return $this->hasMany(TechFieldsLookup::class,'techsupervisor_id','id');
    }
    public function Fieldsupervisor_id_users(){
        return $this->hasMany(TechFieldsLookup::class,'fieldsupervisor_id','id');
    }
}


