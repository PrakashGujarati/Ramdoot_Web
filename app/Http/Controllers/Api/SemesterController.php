<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\Board;
use App\Models\Standard;
use DB;
use Validator;
use App\Models\Subject;

class SemesterController extends Controller
{
    
    public function semesterList(Request $request){

    	$rules = array(
          //  'board_id' => 'required',
          //  'standard_id' => 'required'
             'subject_id' => 'required'
        );
        $messages = array(
            'subject_id.required' => 'Please enter subject id.',
            //'standard_id.required' => 'Please enter standard id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chksubject = Subject::where(['id' => $request->subject_id,'status' => 'Active'])->first();
       // $chkstandard = Standard::where(['id' => $request->standard_id,'status' => 'Active'])->first();

        if(empty($chksubject)){
        	return response()->json([
    			"code" => 400,
			  	"message" => "Subject not found.",
			  	"data" => [],
	        ]);
        }
        else{
        	$getdata = Semester::where(['subject_id' => $request->subject_id,'status' => 'Active'])->orderBy('order_no','asc')->get();

	    	if(count($getdata) > 0){
	    		$data=[];
	    		foreach ($getdata as $value) {
	    			$data[] = ['id' => $value->id,'semester' => $value->semester,'sub_title' => $value->sub_title];
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
