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
		    $str_result = '0123456789';
		  
		    return substr(str_shuffle($str_result),0, $length_of_string);
		}
		$unique_string = random_strings(9);

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
        		$classrooms_arr = Classroom::where(['user_id' => $request->user_id,'status' => 'Active'])->get();
                $classrooms=[];
                foreach ($classrooms_arr as $key_class => $value_class) {
                    //dd($value_class);
                    $classrooms[] = ['id' => $value_class->id,
                        'user_id' => $value_class->user_id,'board_id' => $value_class->board_id,'board' => $value_class->board->name,'medium_id' => $value_class->medium_id,
                        'medium' => isset($value_class->medium->medium_name) ? $value_class->medium->medium_name:'','standard_id' => $value_class->standard_id,'standard' => isset($value_class->standard->standard) ? $value_class->standard->standard:'','subject_id' => $value_class->subject_id,'subject' => 
                        isset($value_class->subject->subject_name) ? 
                        $value_class->subject->subject_name:'','semester_id' => $value_class->semester_id,'semester' => 
                        isset($value_class->semester->semester) ? $value_class->semester->semester:'','division' => $value_class->division,'strenth' => $value_class->strenth,'classroom_id' => $value_class->classroom_id,'type'=> $value_class->type,'status' => $value_class->status];
                }

        	}
        	elseif ($getrole->slug == "Student") {
        		$classroom_details = ClassStudent::where(['user_id' => $request->user_id,'status' => 'aprove'])->get();
        		$classrooms=[];
        		if(count($classroom_details) > 0){
                    $classrooms=[];
        			foreach ($classroom_details as $key => $value) {
                        $aprove = 0;
                        if($value->status == "aprove"){
                            $aprove = 1;
                        }
        				$classdetails = Classroom::where(['id' => $value->class_id])->first();
        				$classrooms[] = ['id' => $classdetails->id,
                        'user_id' => $classdetails->user_id,'board_id' => $classdetails->board_id,'board' => $classdetails->board->name,'medium_id' => $classdetails->medium_id,
                        'medium' => isset($classdetails->medium->medium_name) ? $classdetails->medium->medium_name:'','standard_id' => $classdetails->standard_id,'standard' => isset($classdetails->standard->standard) ? $classdetails->standard->standard:'','subject_id' => $classdetails->subject_id,'subject' => $classdetails->subject->subject_name,'semester_id' => $classdetails->semester_id,'semester' => 
                        isset($classdetails->semester->semester) ? $classdetails->semester->semester:'','division' => $classdetails->division,'strenth' => $classdetails->strenth,'classroom_id' => $classdetails->classroom_id,'type'=> $classdetails->type,'status' => $classdetails->status,'is_aprove' => $aprove];
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
    		'class_id' => 'required',
            'user_id' => 'required',
    		'status' => 'required',
        );
        $messages = array(
        	'class_id.required' => 'Please enter student class id.',
            'user_id' => 'Please enter user id.',
        	'status.required' => 'Please enter status.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $check_classstudent = ClassStudent::where(['class_id' => $request->class_id,'user_id' => $request->user_id])->first();

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
			  	"message" => "Request not found.",
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

        $classrooms_arr = Classroom::where(['classroom_id' => $request->class_id,'status' => 'Active'])->first();

        if($classrooms_arr){
            $add = new ClassStudent;
            $add->user_id = $request->user_id;
            $add->class_id = $classrooms_arr->id;
            $add->status = 'pending';
            $add->save();

            return response()->json([
                "code" => 200,
                "message" => "success",
            ]);
        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "Class not found.",
            ]);
        }

        

    }
}
