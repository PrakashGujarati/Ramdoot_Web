<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Standard;
use DB;
use Validator;
use App\Models\Medium;
class StandardController extends Controller
{
    public function standardList(Request $request){

    	$rules = array(
            'medium_id' => 'required'
        );
        $messages = array(
            'medium_id.required' => 'Please Enter Medium Id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkmedium = Medium::where(['id' => $request->medium_id,'status' => 'Active'])->first();
        if($chkmedium){
        	$getstandard_details = Standard::where(['medium_id' => $request->medium_id,'status' => 'Active'])->select('id','section')->groupBy('section')->get();

	    	if(count($getstandard_details) > 0){

	    		$data=[];$getdata=[];
	    		foreach ($getstandard_details as $value) {                    
	    			$getdata = Standard::select('id','standard','thumbnail','thumbnail_file_type')->where(['medium_id' => $request->medium_id,'section' => $value->section])->orderBy('order_no','asc')->get();

	    			foreach ($getdata as $sub_key => $sub_value) 
	                {
	                	$thumbnail='';
	                	if($sub_value->thumbnail){
	                		if($sub_value->thumbnail_file_type == "Server"){
		                		$thumbnail =  env('APP_URL')."/upload/standard/thumbnail/".$sub_value->thumbnail;		
		                	}
		                	else{
		                		$thumbnail =  $sub_value->thumbnail;	
		                	}	
	                	}
	                	
	                	$standard_data[] = ['id' => $sub_value->id,'standard' => $sub_value->standard,'thumbnail' => $thumbnail];	
		    		}

		    		$data[] = ['id' => $value->id,'section' => $value->section,'standard' => $standard_data,'sub_title' => $value->sub_title];

		    		return response()->json([
		    			"code" => 200,
					  	"message" => "success",
					  	"data" => $data,
			        ]);
	    		}
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
