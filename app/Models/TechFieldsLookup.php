<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechFieldsLookup extends Model
{
    use HasFactory;
    protected $table ="tech_fields_lookup";

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


