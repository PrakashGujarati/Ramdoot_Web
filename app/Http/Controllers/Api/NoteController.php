<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    public function note_list(Request $request){

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
        	//$getdata = Books::where(['unit_id' => $request->unit_id,'status' => 'Active'])->get();
	    	if(count($getunit) > 0){
	    		$data=[];$getdata=[];
	    		foreach ($getunit as $value) {
	    			$getdata = Note::where(['unit_id' => $value->id,'status' => 'Active'])->get();
	    			$bookdata=[];
	    			foreach ($getdata as $value1) {
                        $is_read=0;
                        $c = pdf_view::where(['type' => 'Note','type_id' => $value1->id])->count();
                        if($c)
                        {
                            $is_read = 1;
                        }
                        //$url = $value1->url;
	    				//$thumbnail = $value1->thumbnail;
                        $url = '';
                        if($value1->url){
                            if($value1->url_type == "Server"){
                               // $url =   env('APP_URL')."/upload/unit/url/".$value->url;
                               $url = env('APP_URL').'/'.get_subtitle($value1->unit_id).'/note/url/'.$value1->url;
                            }
                            else{
                                $url = $value1->url;    
                            }
                        }

                        $thumbnail = '';
                        if($value1->thumbnail){
                            if($value1->thumbnail_file_type == "Server"){
                               // $url =   env('APP_URL')."/upload/unit/url/".$value->url;
                               $thumbnail = env('APP_URL').'/'.get_subtitle($value1->unit_id).'/note/thumbnail/'.$value1->thumbnail;
                            }
                            else{
                                $thumbnail = $value1->thumbnail;    
                            }
                        }

	    				$bookdata[] = ['id' => $value1->id,'title' => $value1->title,'sub_title' => $value1->sub_title,
                        'url' => $url,'thumbnail' => $thumbnail,
                        'pages' => $value1->pages,'description' => $value1->description,'label' => $value1->label,'release_date' => $value1->release_date,'is_read' => $is_read];
	    			}

	    			$data[] = ['id' => $value->id,'unit_title' =>$value->title,'book' => $bookdata,'sub_title'=>$value->description];
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
				  	"message" => "Books details not found.",
	 			  	"data" => [],
		        ]);
	    	}		
        }
    }
}
