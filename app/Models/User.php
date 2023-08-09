<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = "users";
    protected $fillable = [
        'national_id',
        'password',
        'full_name',
        'personal_photo',
        'phone_number',
        'email',
        'email_verified_at',
        'type',
        'OTP_password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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
    public function isTechsupervisor(){
        $count = TechFieldsLookup::where('techsupervisor_id',$this->id)->count();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function isFieldsupervisor(){
        $count = TechFieldsLookup::where('fieldsupervisor_id',$this->id)->count();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
}
