<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    use HasFactory;
    
    protected $table = 'question_types';
    public $timestamp = false;

    public function virtudalAssignmentQuestion()
    {
    	return $this->belongsTo(VirtualAssignmentQuestions::class,'question_type');
    }
}
