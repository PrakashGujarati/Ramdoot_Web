<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\semester;
use App\Models\Board;
use App\Models\Standard;
use DB;
use Validator;

class SemesterController extends Controller
{
    
    public function semesterList(Request $request){

    	$rules = array(
            'board_id' => 'required',
            'standard_id' => 'required'
        );
        $messages = array(
            'board_id.required' => 'Please enter board id.',
            'standard_id.required' => 'Please enter standard id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkbaord = Board::where(['id' => $request->board_id,'status' => 'Active'])->first();
        $chkstandard = Standard::where(['id' => $request->standard_id,'status' => 'Active'])->first();

        if(empty($chkbaord)){
        	return response()->json([
    			"code" => 400,
			  	"message" => "Board not found.",
			  	"data" => [],
	        ]);
        }
        elseif (empty($chkstandard)) {
        	return response()->json([
    			"code" => 400,
			  	"message" => "Standard not found.",
			  	"data" => [],
	        ]);
        }else{
        	$getdata = semester::where(['board_id' => $request->board_id,'standard_id' => $request->standard_id,'status' => 'Active'])->get();

	    	if(count($getdata) > 0){
	    		$data=[];
	    		foreach ($getdata as $value) {
	    			$data[] = ['id' => $value->id,'semester' => $value->semester];
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
				  	"message" => "Semester details not found.",
				  	"data" => [],
		        ]);
	    	}	
        }
    }
}
