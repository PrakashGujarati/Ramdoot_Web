<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
    use HasFactory;

    public function board()
    {
    	return $this->belongsTo(Board::class,'board_id');
    }

    public function medium()
    {
    	return $this->belongsTo(Medium::class,'medium_id');
    }

}
