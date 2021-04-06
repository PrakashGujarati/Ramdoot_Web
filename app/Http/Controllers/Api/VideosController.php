<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Videos;
use App\Models\Unit;
use DB;
use Validator;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\VideoBookmark;
use App\Models\User;
use App\Models\SolutionMaterialCount;

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

        	$getunit = Unit::where(['standard_id' => $request->standard_id,'semester_id' => $request->semester_id,'subject_id' => $request->subject_id,'status' => 'Active'])->orderBy('order_no','asc')->get();
        	//$getdata = videos::where(['unit_id' => $request->unit_id,'status' => 'Active'])->get();
            
	    	if(count($getunit) > 0){
	    		$data=[];$getdata=[];
	    		foreach ($getunit as $value) {
	    			$getdata = Videos::where(['unit_id' => $value->id,'status' => 'Active'])->orderBy('order_no','asc')->get();
	    			$videodata=[];
	    			foreach ($getdata as $value1) {

                        $url='';$video_type='';
                        if($value1->url_type == "file"){
                            $url = env('APP_URL')."/upload/videos/url/".$value1->url;
                            $video_type = "Server";
                        }
                        elseif ($value1->url_type == "text") {
                            $url = $value1->url;
                            $video_type = "Youtube";
                        }
	    				$thumbnail = env('APP_URL')."/upload/videos/thumbnail/".$value1->thumbnail;
	    				$videodata[] = ['id' => $value1->id,'title' => $value1->title,'url' => $url,'video_type' => $video_type,'thumbnail' => $thumbnail,'duration' => $value1->duration,'description' => $value1->description,'label' => $value1->label,'release_date' => $value1->release_date];
	    			}

	    			$data[] = ['id' => $value->id,'unit_title' =>$value->title,'video' => $videodata,'sub_title'=>$value->description];
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


    public function addVideoBookmark(Request $request){

        $rules = array(
            'user_id' => 'required',
            'video_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'duration' => 'required'
        );
        $messages = array(
            'user_id' => 'Please enter user id.',
            'video_id' => 'Please enter video id.',
            'start_time' => 'Please enter start time.',
            'end_time' => 'Please enter end time.',
            'duration' => 'Please enter duration.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkuser = User::where(['id' => $request->user_id])->first();

        if($chkuser)
        {
            $add = new VideoBookmark;
            $add->user_id = $request->user_id;
            $add->video_id = $request->video_id;
            $add->start_time = $request->start_time;
            $add->end_time = $request->end_time;
            $add->duration = $request->duration;
            $add->save();

            return response()->json([
                "code" => 200,
                "message" => "success",
            ]);    
        }else{
            return response()->json([
                "code" => 400,
                "message" => "User not found."
            ]);
        }

        

    }

    public function viewVideoBookmark(Request $request){
        $rules = array(
            'user_id' => 'required',
            'video_id' => 'required'
        );
        $messages = array(
            'user_id' => 'Please enter user id.',
            'video_id' => 'Please enter video id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }   

        $chkuser = User::where(['id' => $request->user_id])->first();

        if($chkuser)
        {
            $getdata = VideoBookmark::where(['video_id' => $request->video_id,'user_id' => $request->user_id])->get();
        
            $data=[];
            if(count($getdata) > 0){
                foreach ($getdata as $key => $value) { 
                    //$get_type =  Feature::where(['id' => $value->type_id])->first(); 
                    $data[]=['id' => $value->id,'video_id' => $value->video_id,'user_id' => $value->user_id,
                    'start_time' => $value->start_time,'end_time' => $value->end_time,'duration' => $value->duration];   
                }
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
                "message" => "User not found."
            ]);
        }
    }

        public function addSolutionMaterialCount(Request $request){


            $rules = array(
                'user_id' => 'required',
                'type' => 'required',
                'type_id' => 'required',
                'counttype' => 'required',
            );
            $messages = array(
                'user_id.required' => 'Please enter user id.',
                'type.required' => 'Please enter type.',
                'type_id.required' => 'Please enter type id.',
                'counttype.required' => 'Please enter count type.'
            );

            $chkuser = User::where(['id' => $request->user_id])->first();
            $count=0;
            if($chkuser){

                $chkview = SolutionMaterialCount::where(['type_id' => $request->type_id,'user_id' => $request->user_id])->first();

                if($chkview){

                    if($request->counttype == "whatsapp_count"){
                        SolutionMaterialCount::where(['type_id' => $request->type_id,'user_id' => $request->user_id])->update(['whatsapp_count' => $chkview->whatsapp_count+1]);  
                        $count=$chkview->whatsapp_count+1;
                    }
                    elseif ($request->counttype == "share_count") {
                        SolutionMaterialCount::where(['type_id' => $request->type_id,'user_id' => $request->user_id])->update(['share_count' => $chkview->share_count+1]);
                        $count=$chkview->share_count+1;
                    }
                    elseif ($request->counttype == "show_count") {
                        SolutionMaterialCount::where(['type_id' => $request->type_id,'user_id' => $request->user_id])->update(['show_count' => $chkview->show_count+1]);
                        $count=$chkview->show_count+1;
                    }
                    
                }else{

                    $add =  new solution_material_count;
                    $add->type_id = $request->type_id;
                    $add->user_id = $request->user_id;

                    if($request->counttype == "whatsapp_count"){
                        $add->whatsapp_count = 1;    
                    }
                    elseif ($request->counttype == "share_count") {
                        $add->share_count = 1;
                    }
                    elseif ($request->counttype == "show_count") {
                        $add->show_count = 1;
                    }
                    
                    $add->save();
                    $count=1;
                }


                return response()->json([
                    "code" => 200,
                    "message" => "success",
                    "count"=>$count
                ]);

            }
            else{
                return response()->json([
                    "code" => 400,
                    "message" => "User not found."
                ]);
            }

            

        }


}
