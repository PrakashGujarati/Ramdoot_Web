<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medium extends Model
{
    use HasFactory;
    protected $table = 'mediums';

    protected $fillable = ['name','board_id','medium_name','sub_title','status','order_no'];

    public function board()
    {
    	return $this->belongsTo(Board::class,'board_id');
    }
}
