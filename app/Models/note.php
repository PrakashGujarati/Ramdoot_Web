<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class note extends Model
{
    use HasFactory;
    protected $table = 'notes';

    public function unit()
    {
    	return $this->belongsTo(unit::class,'unit_id');
    }

}
