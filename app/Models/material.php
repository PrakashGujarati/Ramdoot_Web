<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class material extends Model
{
    use HasFactory;

    public function unit()
    {
    	return $this->belongsTo(unit::class,'unit_id');
    }
}
