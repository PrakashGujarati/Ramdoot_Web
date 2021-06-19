<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTable extends Model
{
    use HasFactory;
    protected $table = 'timetables';

    public function class()
    {
        return $this->hasMany(TeacherAssignmentDocument::class,'teacher_assignment_id');
    }

}
