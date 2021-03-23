<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Unit;
use DB;
use Validator;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\PdfBookmark;
use App\Models\Feature;
use App\Models\pdf_view;
use App\Models\User;
use App\Models\Note;

class TextbookController extends Controller
{
    public function textbookList(Request $request){

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
        	//$getdata = Books::where(['unit_id' => $request->unit_id,'status' => 'Active'])->get();
	    	if(count($getunit) > 0){
	    		$data=[];$getdata=[];
	    		foreach ($getunit as $value) {
	    			$getdata = Book::where(['unit_id' => $value->id,'status' => 'Active'])->get();
	    			$bookdata=[];
	    			foreach ($getdata as $value1) {
                        $url = env('APP_URL')."/upload/book/url/".$value1->url;
	    				$thumbnail = env('APP_URL')."/upload/book/thumbnail/".$value1->thumbnail;
	    				$bookdata[] = ['id' => $value1->id,'title' => $value1->title,'sub_title' => $value1->sub_title,
                        'url' => $url,'thumbnail' => $thumbnail,
                        'pages' => $value1->pages,'description' => $value1->description,'label' => $value1->label,'release_date' => $value1->release_date];
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


    public function addBookmark(Request $request){

        $rules = array(
            'user_id' => 'required',
            'type' => 'required',
            'type_id' => 'required',
            'pageno' => 'required',
        );
        $messages = array(
            'user_id.required' => 'Please enter user id.',
            'type.required' => 'Please enter type.',
            'type_id.required' => 'Please enter type id.',
            'pageno.required' => 'Please enter page number.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkuser = User::where(['id' => $request->user_id])->first();

        if($chkuser){

            $add = new PdfBookmark;
            $add->user_id = $request->user_id;
            $add->type_id = $request->type_id;
            $add->pageno = $request->pageno;
            $add->save(); 
            
            return response()->json([
                "code" => 200,
                "message" => "success"
            ]);
        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "User not found."
            ]);
        }

             
    }

    public function viewBookmark(Request $request){

        $rules = array(
            'user_id' => 'required',
            'type' => 'required',
            'type_id' => 'required'
        );
        $messages = array(
            'user_id.required' => 'Please enter user id.',
            'type.required' => 'Please enter type.',
            'type_id.required' => 'Please enter type id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkuser = User::where(['id' => $request->user_id])->first();

        if($chkuser){
            $getdata = PdfBookmark::where(['type_id' => $request->type_id,'user_id' => $request->user_id])->get();
        
            $data=[];
            if(count($getdata) > 0){
                foreach ($getdata as $key => $value) { 
                    $get_type =  Feature::where(['id' => $value->type_id])->first(); 
                    $data[]=['id' => $value->id,'type' => $get_type->title,'type_id' => $get_type->id,'user_id' => $value->user_id,'pageno' => $value->pageno];   
                }
            }

            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $data,
            ]);

        }else{
            return response()->json([
                "code" => 400,
                "message" => "User not found."
            ]);
        }

         

        
           
    }

    public function addPdfCount(Request $request){

        $rules = array(
            'user_id' => 'required',
            'type' => 'required',
            'type_id' => 'required'
        );
        $messages = array(
            'user_id.required' => 'Please enter user id.',
            'type.required' => 'Please enter type.',
            'type_id.required' => 'Please enter type id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkuser = User::where(['id' => $request->user_id])->first();

        if($chkuser){

            $chkview = pdf_view::where(['type_id' => $request->type_id,'user_id' => $request->user_id])->first();

            if($chkview){
                pdf_view::where(['type_id' => $request->type_id,'user_id' => $request->user_id])->update(['count' => $chkview->count+1]);
                $count=$chkview->count+1;
            }else{
                $add =  new pdf_view;
                $add->type_id = $request->type_id;
                $add->user_id = $request->user_id;
                $add->count = 1;
                $add->save();
                $count=1;
            }

            return response()->json([
                "code" => 200,
                "message" => "success",
                "data"=>['count'=>$count]
            ]);

        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "User not found."
            ]);
        }   
    }
    public function note_list(Request $request)
    {

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
            //$getdata = Books::where(['unit_id' => $request->unit_id,'status' => 'Active'])->get();
            if(count($getunit) > 0){
                $data=[];$getdata=[];
                foreach ($getunit as $value) {

                    $getdata = Note::where(['unit_id' => $value->id,'status' => 'Active'])->get();
                    $bookdata=[];
                    foreach ($getdata as $value1) {
                        $url = env('APP_URL')."/upload/book/url/".$value1->url;
                        $thumbnail = env('APP_URL')."/upload/book/thumbnail/".$value1->thumbnail;
                        $bookdata[] = ['id' => $value1->id,'title' => $value1->title,'sub_title' => $value1->sub_title,
                        'url' => $url,'thumbnail' => $thumbnail,
                        'pages' => $value1->pages,'description' => $value1->description,'label' => $value1->label,'release_date' => $value1->release_date];
                    }

                    $data[] = ['id' => $value->id,'unit_title' =>$value->title,'sub_title' => $value->description,'book' => $bookdata];
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