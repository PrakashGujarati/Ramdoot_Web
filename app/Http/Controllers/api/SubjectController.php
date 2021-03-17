<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\Board;
use App\Models\Unit;
use App\Models\Standard;
use App\Models\Subject;
use DB;
use Validator;

class SubjectController extends Controller
{
    
    public function subjectList(Request $request){

    	$rules = array(
            'board_id' => 'required',
            'standard_id' => 'required',
            'semester_id' => 'required'
        );
        $messages = array(
            'board_id.required' => 'Please enter board id.',
            'standard_id.required' => 'Please enter standard id.',
            'semester_id.required' => 'Please enter semester id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkbaord = Board::where(['id' => $request->board_id,'status' => 'Active'])->first();
        $chkstandard = Standard::where(['id' => $request->standard_id,'status' => 'Active'])->first();
        $chksemester = Semester::where(['id' => $request->semester_id,'status' => 'Active'])->first();
        //$chkfeatures = Feature::where(['id' => $request->category_id,'status' => 'Active'])->first();
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
        }
        elseif (empty($chksemester)) {
        	return response()->json([
    			"code" => 400,
			  	"message" => "Semester not found.",
			  	"data" => [],
	        ]);
        }
        else{
			$getdata = Subject::where(['board_id' => $request->board_id,'standard_id' => $request->standard_id,'semester_id' => $request->semester_id,'status' => 'Active'])->get();
			$subjectids = Subject::where(['board_id' => $request->board_id,'standard_id' => $request->standard_id,'semester_id' => $request->semester_id,'status' => 'Active'])->pluck('id');
			$unitcount = Unit::whereIn('subject_id',$subjectids)->count();
	    	if(count($getdata) > 0){
	    		$data=[];
	    		foreach ($getdata as $value) {
                    $url = env('APP_URL')."/upload/subject/url/".$value->url;
	    			$thumbnail = env('APP_URL')."/upload/subject/thumbnail/".$value->thumbnail;
	    			$data[] = ['id' => $value->id,'name' => $value->subject_name,'sub_title' => $value->sub_title,'url' => $url,'thumbnail' => $thumbnail,"units"=>$unitcount];
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
				  	"message" => "Subject details not found.",
	 			  	"data" => [],
		        ]);
	    	}	
        }
    }
}
