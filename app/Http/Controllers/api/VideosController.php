<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\videos;
use App\Models\unit;
use DB;
use Validator;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\semester;

class VideosController extends Controller
{
    
    public function videoList(Request $request){

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
	    			$getdata = videos::where(['unit_id' => $value->id,'status' => 'Active'])->get();
	    			$videodata=[];
	    			foreach ($getdata as $value1) {
                        $url='';
                        if($value1->type == "File"){
                            $url = env('APP_URL')."/upload/videos/url/".$value1->url;
                        }
                        elseif ($value1->type == "URL") {
                            $url = $value1->url;
                        }
	    				$thumbnail = env('APP_URL')."/upload/videos/thumbnail/".$value1->thumbnail;
	    				$videodata[] = ['id' => $value1->id,'title' => $value1->title,'url' => $url,'thumbnail' => $thumbnail,'duration' => $value1->duration,'description' => $value1->description,'label' => $value1->label,'release_date' => $value1->release_date];
	    			}

	    			$data[] = ['id' => $value->id,'unit_title' =>$value->title,'video' => $videodata];
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
				  	"message" => "Videos details not found.",
	 			  	"data" => [],
		        ]);
	    	}		
        }
    }	
}
