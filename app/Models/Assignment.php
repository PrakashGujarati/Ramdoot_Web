<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;
    protected $table = 'assignments';

    public function assignment_question()
    {
        return $this->hasMany(AssignmentQuestion::class,'assignment_id');
    }

}
