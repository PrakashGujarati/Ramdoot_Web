<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exam_student extends Model
{
    use HasFactory;

    public function exam()
    {
     	return $this->belongsTo(Exam::class,'exam_id');
    }

    public function user()
    {
     	return $this->belongsTo(user::class,'user_id');
    }

}
