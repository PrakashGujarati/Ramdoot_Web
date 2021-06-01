<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    use HasFactory;
    protected $table = 'assignment_submissions';

    public function assignment_document()
    {
        return $this->hasMany(AssignmentDocument::class,'assignment_submission_id');
    }

}
