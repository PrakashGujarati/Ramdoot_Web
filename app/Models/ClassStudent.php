<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassStudent extends Model
{
    use HasFactory;
    protected $table = "class_students";

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

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

    public function classroom()
    {
        return $this->belongsTo(Classroom::class,'class_id');
    }
}
