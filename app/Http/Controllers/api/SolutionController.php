<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\solution;
use App\Models\unit;
use DB;
use Validator;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\semester;

class SolutionController extends Controller
{
	public function solutionList(Request $request){

    	$rules = array(
            'unit_id' => 'required'
        );
        $messages = array(
        	'unit_id.required' => 'Please enter unit id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkunit = unit::where(['id' => $request->unit_id,'status' => 'Active'])->first();

        if(empty($chkunit)){
        	return response()->json([
    			"code" => 400,
			  	"message" => "Standard not found.",
			  	"data" => [],
	        ]);
        }
        else{

        	$getdata = unit::where(['id' => $request->unit_id,'status' => 'Active']);
        	
	    	if($getdata->count() > 0){
	    		$data=[];$getdata=[];
				$title="";

	    		$getdata = solution::where(['unit_id' => $request->unit_id,'status' => 'Active'])->get();
	    			$solutiondata=[];
	    			foreach ($getdata as $value1) {
	    				$image = env('APP_URL')."/upload/solution/thumbnail/".$value1->image;
						$title = $value1->label;
	    				$solutiondata[] = ['id' => $value1->id,'question' => $value1->question,'answer' => $value1->answer,'marks' => $value1->marks,'image' => $image,'label' => $value1->label];
	    			}

	    			$data[] = ['id' => $request->unit_id,'unit_title' =>$title,'solution' => $solutiondata];
	    		
	    		return response()->json([
	    			"code" => 200,
				  	"message" => "success",
				  	"data" => $data,
		        ]);
	    	}
	    	else{
	    		return response()->json([
	    			"code" => 400,
				  	"message" => "Solution details not found.",
	 			  	"data" => [],
		        ]);
	    	}		
        }
    }
	/*
	public function solutionList(Request $request){

    	$rules = array(
            'standard_id' => 'required',
            'semester_id' => 'required',
            'subject_id' => 'required',
        );
        $messages = array(
        	'standard_id.required' => 'Please enter standard id.',
            'semester_id.required' => 'Please enter semester id.',
            'subject_id.required' => 'Please enter subject id.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkstandard = Standard::where(['id' => $request->standard_id,'status' => 'Active'])->first();
        $chksemester = semester::where(['id' => $request->semester_id,'status' => 'Active'])->first();
        $chksuject = Subject::where(['id' => $request->subject_id,'status' => 'Active'])->first();

        if(empty($chkstandard)){
        	return response()->json([
    			"code" => 400,
			  	"message" => "Standard not found.",
			  	"data" => [],
	        ]);
        }
        elseif (empty($chksemester)) {
        	return response()->json([
    			"code" => 400,
			  	"message" => "Semester not found.",
			  	"data" => [],
	        ]);
        }
        elseif (empty($chksuject)) {
        	return response()->json([
    			"code" => 400,
			  	"message" => "Subject not found.",
			  	"data" => [],
	        ]);
        }
        else{

        	$getunit = unit::where(['standard_id' => $request->standard_id,'semester_id' => $request->semester_id,'subject_id' => $request->subject_id,'status' => 'Active'])->get();
        	//$getdata = videos::where(['unit_id' => $request->unit_id,'status' => 'Active'])->get();
	    	if(count($getunit) > 0){
	    		$data=[];$getdata=[];
	    		foreach ($getunit as $value) {
	    			$getdata = solution::where(['unit_id' => $value->id,'status' => 'Active'])->get();
	    			$solutiondata=[];
	    			foreach ($getdata as $value1) {
	    				$image = env('APP_URL')."/upload/solution/".$value1->image;
	    				$solutiondata[] = ['id' => $value1->id,'question' => $value1->question,'answer' => $value1->answer,'marks' => $value1->marks,'image' => $image,'label' => $value1->label];
	    			}

	    			$data[] = ['id' => $value->id,'unit_title' =>$value->title,'solution' => $solutiondata];
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
				  	"message" => "Solution details not found.",
	 			  	"data" => [],
		        ]);
	    	}		
        }
    }*/
}
