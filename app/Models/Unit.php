<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $fillable = ['board_id','medium_id','standard_id','subject_id','semester_id','title','sub_title',
    'url_type','url','thumbnail_file_type','thumbnail','pages','description','status','order_no'];

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
    
    public function board()
    {
        return $this->belongsTo(Board::class,'board_id');
    }

    public function medium()
    {
        return $this->belongsTo(Medium::class,'medium_id');
    }

}
