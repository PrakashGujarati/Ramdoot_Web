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
            if(!empty($url) || $url == "0"){
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


function send_notification($utoken, $message, $title = null) {
        
    $API_ACCESS_KEY = 'AAAAZkwzjLI:APA91bGJMNIZjlE8ormC8l_Re1CYwSolNwEa_rhyk7EPl1tzwF1EnqHzq5VUeEDMFGFErQQivaTYx1jNX7bfP7BJyx1dqag0vaAJ3p1V8vp9R5RPszIumzOF6EKFVvrM8vdKWqUV-DLg';

    $headers = array
    (
    'Authorization: key=' . $API_ACCESS_KEY,
    'Content-Type: application/json'
    );                

    $token = $utoken;

    $msg = array(
    'alert' => $message,
    'title' => $title,
    'message' => $message,
    'notification_type' => "",
    'user_type' => "",
    'sound' => 'default',
    'client_id' => "",
    'flag'=>"",
    );

    $notification = array(
    'title' => $title,
    'body' => $message,               
    'sound' => 'default',
    );
    

    $fields = array(
    'to' => $token,
    'data' => $msg,
    'priority' => 'high',
    'vibrate' => 1,             
    'notification' => $notification
    );
        
    try {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        
        $result = curl_exec($ch);
        curl_close($ch);
        $errMsg = '';
        $res = (array) json_decode($result);
        print_r($res);
        $errMsg = '';
        
        if (!empty($res)) {
            if ($res['failure'] == 1) {
                $errMsg = $res['results'][0]->error;
            }
        }
        
        
    } catch (Exception $e) {
            Log::info("ERROR IN CACHE");
    }                    

}

