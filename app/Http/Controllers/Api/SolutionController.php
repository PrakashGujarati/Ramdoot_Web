<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Solution;
use App\Models\Unit;
use DB;
use Validator;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\QuestionType;

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

        $chkunit = Unit::where(['id' => $request->unit_id,'status' => 'Active'])->first();

        if(empty($chkunit)){
        	return response()->json([
    			"code" => 400,
			  	"message" => "Standard not found.",
			  	"data" => [],
	        ]);
        }
        else{

        	$getdata = Unit::where(['id' => $request->unit_id,'status' => 'Active']);
        	
	    	if($getdata->count() > 0){
	    		$data=[];$getdata=[];
				$title="";

	    		$getdata = Solution::where(['unit_id' => $request->unit_id,'status' => 'Active'])
	    		->groupBy('question_type')->get();
	    			
	    			foreach ($getdata as $value1) {

	    				$getdata_solution = Solution::where(['question_type' => $value1->question_type,
	    					'status' => 'Active'])->orderBy('order_no','asc')->get();
	    				$solutiondata=[];
	    				foreach ($getdata_solution as $value_sub) {

	    					$image = env('APP_URL')."/upload/solution/thumbnail/".$value_sub->image;
							$title = $value_sub->label;
		    				$solutiondata[] = ['id' => $value_sub->id,'question' => $value_sub->question,'answer' => $value_sub->answer,'marks' => $value_sub->marks,'image' => $image,'label' => $value_sub->label];
	    				}

	    				$sub_title = Unit::where(['id' => $request->unit_id,'status' => 'Active'])->first();
		    			if($sub_title)
		    			{
		    				$sub_title=$sub_title->description;
		    			}
		    			else
		    			{
		    				$sub_title="";
		    			}	
		    			//$data[] = ['id' => $request->unit_id,'unit_title' =>$title,'solution' => $solutiondata,"sub_title"=>$sub_title];
		    			$getquestion_type_details = QuestionType::where(['id' => $value1->question_type])->first();
		    			$data[] = ['question_type' => $getquestion_type_details->question_type,'solution' => $solutiondata];
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
        $chksemester = Semester::where(['id' => $request->semester_id,'status' => 'Active'])->first();
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

        	$getunit = Unit::where(['standard_id' => $request->standard_id,'semester_id' => $request->semester_id,'subject_id' => $request->subject_id,'status' => 'Active'])->get();
        	//$getdata = videos::where(['unit_id' => $request->unit_id,'status' => 'Active'])->get();
	    	if(count($getunit) > 0){
	    		$data=[];$getdata=[];
	    		foreach ($getunit as $value) {
	    			$getdata = Solution::where(['unit_id' => $value->id,'status' => 'Active'])->get();
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
