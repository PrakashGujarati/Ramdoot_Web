<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualAssignmentQuestions extends Model
{
    use HasFactory;
    protected $table = 'virtual_assignment_questions';

    public function question_solution()
    {
    	return $this->hasMany(Solution::class,'id','question_id');
    }

    public function question()
    {
    	return $this->hasMany(Question::class,'id','question_id');
    }

    public function questionType()
    {
    	return $this->hasOne(QuestionType::class,'id','question_type','id');
    }
}
