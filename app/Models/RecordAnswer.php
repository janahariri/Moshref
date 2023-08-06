<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordAnswer extends Model
{
    use HasFactory;

    public function RecordQuestion(){
        return $this->belongsTo(RecordQuestion::class);
    }
}
