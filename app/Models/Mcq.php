<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mcq extends Model
{
    use HasFactory;

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function dataLog()
    {
        return $this->morphMany(UserDataLog::class, 'logable');
    }
}
