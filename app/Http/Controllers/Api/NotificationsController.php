<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use App\Models\User;
use App\Models\Notification;

class NotificationsController extends Controller
{
    public function notification_list(Request $request)
    {
    	$rules = array(
            'user_id' => 'required'
        );
        $messages = array(
        	'user_id.required' => 'Please enter user id.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $check_user = User::where(['id' => $request->user_id])->first();

		if($check_user){
			$get_notification = Notification::where(['user_id' => $check_user->id])->get();

			$notification_details=[];
			foreach ($get_notification as $key => $value) {
				$url = "";
				if($value->image){
	        		$url =  config('ramdoot.appurl')."/upload/notifications/".$value->image;		
	        	}	
    			$notification_details[] = ['id' => $value->id,'device_id' => $value->device_id,'user_id' => $value->user_id,'title' => $value->title,'message' => $value->message,'image' => $url,'is_read' => $value->is_read,'created_at' => 
    			$value->created_at,'updated_at' => $value->updated_at];
				//$notification_details
			}
			

			if(count($notification_details) > 0){
				return response()->json([
	    			"code" => 200,
				  	"message" => "success",
	 			  	"data" => $notification_details,
		        ]);	
			}
			else{
				return response()->json([
	    			"code" => 400,
				  	"message" => "Notification not found.",
	 			  	"data" => [],
		        ]);	
			}
			
		}
		else{
			return response()->json([
    			"code" => 400,
			  	"message" => "User not found.",
 			  	"data" => [],
	        ]);
		}
    }
}
