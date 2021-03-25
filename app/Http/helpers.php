<?php


use Illuminate\Support\Facades\Auth;
use App\Models\UserDataLog;
use App\Models\UserDataReview;

function storeLog($type,$type_id,$upload_time,$operation)
{
    $add=new UserDataLog;
    $add->user_id=Auth::user()->id;
    $add->type=$type;
    $add->type_id=$type_id;
    $add->upload_time=$upload_time;
    $add->operation=$operation;
    $add->save();
}
function storeReview($type,$type_id,$review_time,$status,$remarks)
{
    $add=new UserDataReview;
    $add->user_id=Auth::user()->id;
    $add->type=$type;
    $add->type_id=$type_id;
    $add->review_time=$review_time;
    $add->status=$status;
    $add->remarks=$remarks;
    $add->save();   
}