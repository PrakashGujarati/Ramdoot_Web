<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
    use HasFactory;
    protected $fillable = ['board_id','medium_id','standard','section','thumbnail','status','order_no'];

    public function board()
    {
    	return $this->belongsTo(Board::class,'board_id');
    }

    public function medium()
    {
    	return $this->belongsTo(Medium::class,'medium_id');
    }

    public function getThumbnailAttribute($value)
    {
        return "/upload/standard/thumbnail/".$value;
    }

}
