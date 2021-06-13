<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $table = 'materials';
    protected $fillable = ['board_id','medium_id','standard_id','subject_id','semester_id','unit_id','user_id',
    'question','answer','marks','image_file_type','image','label','question_type','level','status','order_no'];

    public function board()
    {
        return $this->belongsTo(Board::class, 'board_id');
    }

    public function medium()
    {
        return $this->belongsTo(Medium::class, 'medium_id');
    }


    public function standard()
    {
        return $this->belongsTo(Standard::class, 'standard_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function questionType()
    {
        return $this->belongsTo(QuestionType::class, 'question_type');
    }
    public function dataLog()
    {
        return $this->morphMany(UserDataLog::class, 'logable');
    }
}
