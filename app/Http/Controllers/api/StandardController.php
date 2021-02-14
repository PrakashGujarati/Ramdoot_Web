<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Standard;
use DB;
use Validator;
use App\Models\Board;

class StandardController extends Controller
{
    public function standardList(Request $request){

    	$rules = array(
            'board_id' => 'required'
        );
        $messages = array(
            'board_id.required' => 'Please Enter Board Id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkbaord = Board::where(['id' => $request->board_id,'status' => 'Active'])->first();

        if($chkbaord){
        	$getboard_details = Standard::where(['board_id' => $request->board_id,'status' => 'Active'])->select('id','section')->groupBy('section')->get();

	    	if(count($getboard_details) > 0){

	    		$data=[];$getdata=[];
	    		foreach ($getboard_details as $value) {
	    			$getdata = Standard::select('id','standard')->where('section',$value->section)->get();
	    			$data[] = ['id' => $value->id,'section' => $value->section,'standard' => $getdata];
	    		}

	    		return response()->json([
	    			"code" => 200,
				  	"message" => "success",
				  	"data" => $data,
		        ]);
	    	}
	    	else{
	    		return response()->json([
	    			"code" => 400,
				  	"message" => "Standard not found.",
				  	"data" => [],
		        ]);
	    	}	
	    }
        else{
        	return response()->json([
    			"code" => 400,
			  	"message" => "Board details not found.",
			  	"data" => [],
	        ]);
        }

    	

    }
}
