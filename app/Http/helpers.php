<?php


use Illuminate\Support\Facades\Auth;
use App\Models\UserDataLog;
use App\Models\UserDataReview;
use Illuminate\Support\Facades\DB;

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
function storeReview($type,$type_id,$review_time,$status="Pending")
{
    $add=new UserDataReview;
    $add->user_id=Auth::user()->id;
    $add->type=$type;
    $add->type_id=$type_id;
    $add->review_time=$review_time;
    $add->status=$status;
    $add->save();   
}
function above_order($table,$order_no,$key=null,$value=null)
{
    if($key != null)
    {
        $data=DB::table($table)->where($key,$value)->where('order_no',$order_no)->first();
        if($data)
        {
            $prev = DB::table($table)->where($key,$value)->where('order_no', '<', $order_no)->orderBy('order_no','desc')->first();
            if($prev)
            {
                $prevOrder=$prev->order_no;
                $updData=DB::table($table)->where('id',$prev->id)->update(['order_no'=>$data->order_no]);
                $updDataNew=DB::table($table)->where('id',$data->id)->update(['order_no'=>$prevOrder]);
            }
        }
    }
    else
    {
        $data=DB::table($table)->where('order_no',$order_no)->first();
        if($data)
        {
            $prev = DB::table($table)->where('order_no', '<', $order_no)->orderBy('order_no','desc')->first();
            if($prev)
            {
                $prevOrder=$prev->order_no;
                $updData=DB::table($table)->where('id',$prev->id)->update(['order_no'=>$data->order_no]);
                $updDataNew=DB::table($table)->where('id',$data->id)->update(['order_no'=>$prevOrder]);
            }
        }    
    }
    
}
function below_order($table,$order_no,$key=null,$value=null)
{

    if($key != null)
    {
        $data=DB::table($table)->where($key,$value)->where('order_no',$order_no)->first();
        if($data)
        {
            $next = DB::table($table)->where($key,$value)->where('order_no', '>', $order_no)->orderBy('order_no','asc')->first();
            if($next)
            {
                $nextOrder=$next->order_no;
                $updData=DB::table($table)->where('id',$next->id)->update(['order_no'=>$data->order_no]);
                $updDataNew=DB::table($table)->where('id',$data->id)->update(['order_no'=>$nextOrder]);
            }
        }
    }
    else
    {
        $data=DB::table($table)->where('order_no',$order_no)->first();
        if($data)
        {
            $next = DB::table($table)->where('order_no', '>', $order_no)->orderBy('order_no','asc')->first();
            if($next)
            {
                $nextOrder=$next->order_no;
                $updData=DB::table($table)->where('id',$next->id)->update(['order_no'=>$data->order_no]);
                $updDataNew=DB::table($table)->where('id',$data->id)->update(['order_no'=>$nextOrder]);
            }
        }       
    }    
}
function delete_order($table,$id,$is_subject=null)
{
    $data=DB::table($table)->where('id',$id)->first();
    if($data)
    {
        if($is_subject == 1)
        {
            $datas=DB::table($table)->where('id','>',$data->id)->where('semester_id',$data->semester_id)->where('status','Active')->get();
            if($datas)
            {
                $number=$data->order_no;
                foreach ($datas as $key => $value) {
                    $upd=DB::table($table)->where('id',$value->id)->update(['order_no'=>$number]);
                    $number=$number+1;
                }
            }
        }
        else
        {
            $datas=DB::table($table)->where('id','>',$data->id)->where('status','Active')->get();
            if($datas)
            {
                $number=$data->order_no;
                foreach ($datas as $key => $value) {
                    $upd=DB::table($table)->where('id',$value->id)->update(['order_no'=>$number]);
                    $number=$number+1;
                }
            }    
        }
        
        $upd=DB::table($table)->where('id',$id)->update(['order_no'=>0]);
    }
}

function imagePathCreate($imagePath = ''){
    if(!empty($imagePath)){
        $originalPath = public_path();
        $urlArr = explode('/',$imagePath);

        foreach($urlArr as $url){
            if(!empty($url)){
                $originalPath .= '/'.$url;
                if (!file_exists($originalPath)) {
                    mkdir($originalPath, 0777, true);
                }
            }
        }
        return $originalPath."/";
    }
    return public_path()."/upload/";
}

