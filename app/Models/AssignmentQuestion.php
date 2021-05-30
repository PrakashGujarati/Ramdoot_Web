<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentQuestion extends Model
{
    use HasFactory;
    protected $table = 'assignment_questions';

    public function question()
    {
    	return $this->hasMany(Solution::class,'id','question_id');
    }
}
