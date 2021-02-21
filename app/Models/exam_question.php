<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exam_question extends Model
{
    use HasFactory;
    public function exam()
    {
    	return $this->belongsTo(exam::class,'exam_id');
    }

    public function question()
    {
    	return $this->belongsTo(question::class,'question_id');
    }
}
