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
			if(count($get_notification) > 0){
				return response()->json([
	    			"code" => 200,
				  	"message" => "success",
	 			  	"data" => $get_notification,
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
