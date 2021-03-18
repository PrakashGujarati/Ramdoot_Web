<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exam_question extends Model
{
    use HasFactory;
    
    public function exam()
    {
    	return $this->belongsTo(Exam::class,'exam_id');
    }

    public function question()
    {
    	return $this->belongsTo(Question::class,'question_id');
    }
}
