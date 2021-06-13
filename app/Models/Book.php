<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = ['board_id','medium_id','standard_id','subject_id','semester_id','unit_id','user_id',
    'title','sub_title','url_type','url','thumbnail','thumbnail_file_type','pages','description','edition','label','release_date','status','order_no'];

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
    public function dataLog()
    {
        return $this->morphMany(UserDataLog::class, 'logable');
    }
}
