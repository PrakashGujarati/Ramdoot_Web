<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'class_id',
        'timetable_id',
        'description',
        'date'
    ];
    public function attendanceStudent()
    {
        return $this->hasMany(AttendanceStudent::class);
    }
    
}
