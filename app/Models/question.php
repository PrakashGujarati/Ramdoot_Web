<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    use HasFactory;
    
    protected $fillable = ['board_id','medium_id','standard_id','semester_id','subject_id','unit_id','question','note','option_a','option_b','option_c','option_d','answer','per_question_marks'];

    public function unit()
    {
    	return $this->belongsTo(unit::class,'unit_id');
    }
}
