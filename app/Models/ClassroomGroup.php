<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomGroup extends Model
{
    use HasFactory;
    protected $table = "classroom_groups";

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function standard()
    {
    	return $this->belongsTo(Standard::class,'standard_id');
    }

}
