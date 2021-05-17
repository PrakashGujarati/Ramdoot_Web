<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;
    protected $table = "classes";
    // protected $fillable = ['board_id','medium_id','standard_id','subject_name','sub_title','thumbnail_file_type','thumbnail','status','order_no'];

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
        return $this->belongsTo(subject::class,'subject_id');
    }
}
