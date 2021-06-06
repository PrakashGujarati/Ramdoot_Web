<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAssignment extends Model
{
    use HasFactory;
    protected $table = 'teacher_assignments';

    public function assignment_document()
    {
        return $this->hasMany(TeacherAssignmentDocument::class,'teacher_assignment_id');
    }

}
