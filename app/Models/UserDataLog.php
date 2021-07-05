<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDataLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected $fillable = ['name','sub_title','abbreviation','thumbnail_file_type','thumbnail','status','order_no'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function logable()
    {
        return $this->morphTo();
    }
}
