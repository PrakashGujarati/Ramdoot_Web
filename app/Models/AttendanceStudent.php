<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceStudent extends Model
{
    use HasFactory;
    protected $fillable = [
        'attendance_id',
        'student_id',
        'is_present'
    ];
    public function student()
    {
        return $this->belongsTo(User::class,'student_id','id');
    }
    public function attendance()
    {
        return $this->belongsTo(Attendance::class,'attendance_id','id');
    }
}
