<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalQuestion extends Model
{
    use HasFactory;
    
    protected $table = "external_questiones";

    //protected $fillable = ['board_id','medium_id','standard_id','semester_id','subject_id','unit_id','question','note','option_a','option_b','option_c','option_d','answer','per_question_marks'];


    public function board()
	{
	    return $this->belongsTo(Board::class,'board_id');
	}

	public function medium()
	{
	    return $this->belongsTo(Medium::class,'medium_id');
	}


	public function standard()
	{
	  return $this->belongsTo(Standard::class,'standard_id');
	}

	public function semester()
	{
	  return $this->belongsTo(Semester::class,'semester_id');
	}

	public function subject()
	{
	  return $this->belongsTo(Subject::class,'subject_id');
	}


    public function unit()
    {
    	return $this->belongsTo(Unit::class,'unit_id');
    }
}
