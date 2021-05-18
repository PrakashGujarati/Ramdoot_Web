<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Validator;
use App\Models\Board;
use App\Models\Medium;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\Classroom;
use App\Models\ClassStudent;
use App\Models\User;
use App\Models\Role;

class RamdootEduController extends Controller
{
    public function create_class(Request $request){

    	$rules = array(
    		'user_id' => 'required',
            'board_id' => 'required',
            'medium_id' => 'required',
    		'standard_id' => 'required',
    		'subject_id' => 'required',
           // 'semester_id' => 'required',
            'division' => 'required',
            'strenth' => 'required',
            'type' => 'required',
        );
        $messages = array(
        	'user_id.required' => 'Please enter user id.',
            'board_id.required' => 'Please enter board id.',
            'medium_id.required' => 'Please enter medium id.',
        	'standard_id.required' => 'Please enter standard id.',
        	'subject_id.required' => 'Please enter subject id.',
           // 'semester_id.required' => 'Please enter semester id.',
            'division.required' => 'Please enter division.',
            'strenth.required' => 'required enter strenth.',
            'type.required' => 'required enter type',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkboard = Board::where(['id' => $request->board_id,'status' => 'Active'])->first();
        $chkmedium = Medium::where(['id' => $request->medium_id,'status' => 'Active'])->first();
        $chkstandard = Standard::where(['id' => $request->standard_id,'status' => 'Active'])->first();
        $chksubject = Subject::where(['id' => $request->subject_id,'status' => 'Active'])->first();
        $chksemester = Semester::where(['id' => $request->semester_id,'status' => 'Active'])->first();

        function random_strings($length_of_string)
		{
		    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		  
		    return substr(str_shuffle($str_result),0, $length_of_string);
		}
		$unique_string = random_strings(10);

    	if(empty($chkboard)){
        	return response()->json([
    			"code" => 400,
			  	"message" => "Board not found.",
			  	"data" => [],
	        ]);
        }
        elseif (empty($chkmedium)) {
        	return response()->json([
    			"code" => 400,
			  	"message" => "Medium not found.",
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
        elseif (empty($chksubject)) {
        	return response()->json([
    			"code" => 400,
			  	"message" => "Subject not found.",
			  	"data" => [],
	        ]);
        }
      //   elseif (empty($chksemester)) {
      //   	return response()->json([
    		// 	"code" => 400,
			  	// "message" => "Semester not found.",
			  	// "data" => [],
	     //    ]);
      //   }
        else{

        	$add = new Classroom;
	    	$add->user_id = $request->user_id;
	    	$add->board_id = $request->board_id;
	    	$add->medium_id = $request->medium_id;
	    	$add->standard_id = $request->standard_id;
	    	$add->subject_id = $request->subject_id;
	    	$add->semester_id = isset($request->semester_id) ? $request->semester_id:0;
	    	$add->division = $request->division;
	    	$add->strenth = $request->strenth;
	    	$add->classroom_id  = $unique_string;
	    	$add->type = $request->type;
	    	$add->save();

	    	return response()->json([
    			"code" => 200,
			  	"message" => "success",
			  	"data" => $add,
	        ]);
        }


    }

    public function view_class(Request $request){

    	$rules = array(
    		'user_id' => 'required'
        );
        $messages = array(
        	'user_id.required' => 'Please enter user id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $usercheck = User::where(['id' => $request->user_id])->first();

        if($usercheck){
        	$getrole = Role::where(['id' => $usercheck->role_id])->first();
        	if($getrole->slug == "Teacher"){
        		$classrooms = Classroom::where(['user_id' => $request->user_id,'status' => 'Active'])->get();
        	}
        	elseif ($getrole->slug == "Student") {
        		$classroom_details = ClassStudent::where(['user_id' => $request->user_id,'status' => 'aprove'])->get();
        		$classrooms=[];
        		if(count($classroom_details) > 0){
        			foreach ($classroom_details as $key => $value) {
        				$classdetails = Classroom::where(['id' => $value->class_id])->first();
        				$classrooms[] = $classdetails;
        			}
        		}
        	}

			return response()->json([
    			"code" => 200,
			  	"message" => "success",
			  	"data" => $classrooms,
	        ]);        	

        }
        else{
        	return response()->json([
    			"code" => 400,
			  	"message" => "User not found.",
			  	"data" => [],
	        ]);
        }

    }

    public function update_request(Request $request){
    		
    	$rules = array(
    		'class_student_id' => 'required',
    		'status' => 'required',
        );
        $messages = array(
        	'class_student_id.required' => 'Please enter student class id.',
        	'status.required' => 'Please enter status.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $check_classstudent = ClassStudent::where(['id' => $request->class_student_id])->first();

        if($check_classstudent){
        	ClassStudent::where(['id' => $check_classstudent->id])->update(['status' => $request->status]);	
        	return response()->json([
    			"code" => 200,
			  	"message" => "success"
	        ]);
        }
        else{
        	return response()->json([
    			"code" => 400,
			  	"message" => "Class Student id not found.",
	        ]);
        }

        

    }

    public function join_class(Request $request){
    	
    	$rules = array(
    		'class_id' => 'required',
    		'user_id' => 'required',
        );
        $messages = array(
        	'class_id' => 'Please enter class id.',
    		'user_id' => 'Please enter user id.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }	

        $add = new ClassStudent;
    	$add->user_id = $request->class_id;
    	$add->class_id = $request->user_id;
    	$add->status = 'pending';
    	$add->save();

    	return response()->json([
			"code" => 200,
		  	"message" => "success",
        ]);

    }
}
