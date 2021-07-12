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
use App\Models\Unit;
use App\Models\Solution;
use App\Models\Question;
use App\Models\QuestionType;
use App\Models\VirtualAssignmentQuestions;
use App\Models\Assignment;
use App\Models\AssignmentQuestion;
use App\Models\AssignmentStudent;
use App\Models\AssignmentSubmission;
use App\Models\AssignmentDocument;
use App\Models\TeacherAssignment;
use App\Models\TeacherAssignmentDocument;
use App\Models\ClassroomGroup;
use App\Models\TimeTable;
use App\Models\ExternalQuestion;
use App\Models\Attendance;
use App\Models\AttendanceStudent;


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

    public function edit_class(Request $request){
        $rules = array(
            'class_id' => 'required',
            'user_id' => 'required',
            'board_id' => 'required',
            'medium_id' => 'required',
            'standard_id' => 'required',
            'subject_id' => 'required',
           // 'semester_id' => 'required',
            'division' => 'required',
            'strenth' => 'required',
            'type' => 'required'
        );
        $messages = array(
            'class_id.required' => 'Please enter class id.',
            'user_id.required' => 'Please enter user id.',
            'board_id.required' => 'Please enter board id.',
            'medium_id.required' => 'Please enter medium id.',
            'standard_id.required' => 'Please enter standard id.',
            'subject_id.required' => 'Please enter subject id.',
           // 'semester_id.required' => 'Please enter semester id.',
            'division.required' => 'Please enter division.',
            'strenth.required' => 'required enter strenth.',
            'type.required' => 'required enter type'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $check_class = Classroom::where(['id' => $request->class_id,'status' => 'Active'])->first();

        if($check_class){

            $chkboard = Board::where(['id' => $request->board_id,'status' => 'Active'])->first();
            $chkmedium = Medium::where(['id' => $request->medium_id,'status' => 'Active'])->first();
            $chkstandard = Standard::where(['id' => $request->standard_id,'status' => 'Active'])->first();
            $chksubject = Subject::where(['id' => $request->subject_id,'status' => 'Active'])->first();
            $chksemester = Semester::where(['id' => $request->semester_id,'status' => 'Active'])->first();

            // function random_strings($length_of_string)
            // {
            //     $str_result = '0123456789';
              
            //     return substr(str_shuffle($str_result),0, $length_of_string);
            // }
            // $unique_string = random_strings(9);

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
        //  elseif (empty($chksemester)) {
        //    return response()->json([
            //  "code" => 400,
                // "message" => "Semester not found.",
                // "data" => [],
        //    ]);
        //  }
            else{

                $add = Classroom::find($request->class_id);
                $add->user_id = $request->user_id;
                $add->board_id = $request->board_id;
                $add->medium_id = $request->medium_id;
                $add->standard_id = $request->standard_id;
                $add->subject_id = $request->subject_id;
                $add->semester_id = isset($request->semester_id) ? $request->semester_id:0;
                $add->division = $request->division;
                $add->strenth = $request->strenth;
              //  $add->classroom_id  = $unique_string;
                $add->type = $request->type;
                $add->save();

                return response()->json([
                    "code" => 200,
                    "message" => "success",
                    "data" => $add,
                ]);
            }
        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "Classroom not found.",
                "data" => [],
            ]);
        }
    }

    public function delete_class(Request $request){
        $rules = array(
            'class_id' => 'required'
        );
        $messages = array(
            'class_id.required' => 'Please enter class id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $check_class = Classroom::where(['id' => $request->class_id])->first();
        $check_class->status = "Deleted";
        $check_class->save();
        
        
        if($check_class){

            $check_class = Classroom::find($check_class->id);
            $check_class->status = "Deleted";
            $check_class->save();
            //Classroom::where(['id' => $request->class_id])->delete();
            return response()->json([
                "code" => 200,
                "message" => "success",
            ]);
        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "Classroom not found.",
                "data" => [],
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
        		if($request->standard_id != 0)
                {
                    $classrooms_arr = Classroom::where(['user_id' => $request->user_id,'standard_id'=> $request->standard_id,'status' => 'Active'])->get();
                }else
                {
                    $classrooms_arr = Classroom::where(['user_id' => $request->user_id,'status' => 'Active'])->get();
                }
                $classrooms=[];
                foreach ($classrooms_arr as $key_class => $value_class) {

                    //dd($value_class);
                    $classrooms[] = ['id' => $value_class->id,
                        'user_id' => $value_class->user_id,'board_id' => $value_class->board_id,'board' => 
                        isset($value_class->board->sub_title) ? $value_class->board->sub_title:'','medium_id' => $value_class->medium_id,
                        'medium' => isset($value_class->medium->sub_title) ? $value_class->medium->sub_title:'','standard_id' => $value_class->standard_id,'standard' => isset($value_class->standard->standard) ? $value_class->standard->standard:'','subject_id' => $value_class->subject_id,'subject' => 
                        isset($value_class->subject->sub_title) ? $value_class->subject->sub_title:'',
                        'semester_id' => $value_class->semester_id,'semester' => 
                        isset($value_class->semester->semester) ? $value_class->semester->semester:'','division' => $value_class->division,'strenth' => $value_class->strenth,'classroom_id' => $value_class->classroom_id,'type'=> $value_class->type,'status' => $value_class->status];
                }

        	}
        	elseif ($getrole->slug == "Student") {
                if($request->standard_id != 0)
                {
                    $classroom_details = ClassStudent::whereHas('classroom', function($q) use($request){
                        $q->where(['status'=>'Active','standard_id'=>$request->standard_id]);
                    })->where(['user_id' => $request->user_id])->where('status','!=','reject')->get();
                }else
                {
                    $classroom_details = ClassStudent::whereHas('classroom', function($q) use($request){
                        $q->where(['status'=>'Active']);
                    })->where(['user_id' => $request->user_id])->where('status','!=','reject')->get();
                }
        		$classrooms=[];
        		if(count($classroom_details) > 0){
                    $classrooms=[];
        			foreach ($classroom_details as $key => $value) {
                        $aprove = 0;
                        if($value->status == "aprove"){
                            $aprove = 1;
                        }

        				$classdetails = Classroom::where(['id' => $value->class_id,'status' => 'Active'])->first();
                        if($classdetails){

                            $classrooms[] = ['id' => $classdetails->id,
                        'user_id' => $classdetails->user_id,'board_id' => $classdetails->board_id,'board' => 
                        isset($classdetails->board->sub_title) ? $classdetails->board->sub_title:'','medium_id' => $classdetails->medium_id,
                        'medium' => isset($classdetails->medium->sub_title) ? $classdetails->medium->sub_title:'','standard_id' => $classdetails->standard_id,'standard' => isset($classdetails->standard->standard) ? $classdetails->standard->standard:'','subject_id' => $classdetails->subject_id,'subject' => $classdetails->subject->sub_title,'semester_id' => $classdetails->semester_id,'semester' => 
                        isset($classdetails->semester->semester) ? $classdetails->semester->semester:'','division' => $classdetails->division,'strenth' => $classdetails->strenth,'classroom_id' => $classdetails->classroom_id,'type'=> $classdetails->type,'status' => $classdetails->status,'is_aprove' => $aprove,'created_at' => $value->created_at,'updated_at' => $value->updated_at];
                                
                        }
        				
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

            $check_class = ClassStudent::where(['user_id' => $request->user_id,'class_id' => $classrooms_arr->id])->where('status','!=','reject')->first();

            if($check_class){
                return response()->json([
                    "code" => 400,
                    "message" => "You have already join this class.",
                ]);
            }
            else{

                $checkclasses = ClassStudent::where(['user_id' => $request->user_id,'class_id' => $classrooms_arr->id])->first();

                if($checkclasses){
                    $add = ClassStudent::find($checkclasses->id);
                    $add->user_id = $request->user_id;
                    $add->class_id = $classrooms_arr->id;
                    $add->status = 'pending';
                    $add->save();    
                }
                else{
                    $add = new ClassStudent;
                    $add->user_id = $request->user_id;
                    $add->class_id = $classrooms_arr->id;
                    $add->status = 'pending';
                    $add->save();
                }

                

                return response()->json([
                    "code" => 200,
                    "message" => "success",
                ]);
            }
        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "Class not found.",
            ]);
        }
    }

    public function teacher_request_list(Request $request){
        $rules = array(
            'class_id' => 'required',
            'assignment_id' => 'required'
        );
        $messages = array(
            'class_id' => 'Please enter class id.',
            'assignment_id' => 'Please enter assignment id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        if($request->assignment_id != "0"){


            //$check_assignment = Assignment::where(['id' => $request->assignment_id])->first();
            $check_assignment = Assignment::where(['id' => $request->assignment_id,'status' => 'Active'])->first();

            if($check_assignment){

                $classroom_details = ClassStudent::where(['class_id' => $request->class_id])
                            ->where('status','!=','reject')->get();

                $classrooms=[];$isAssignmentSent=0;
                if(count($classroom_details) > 0){
                    $classrooms=[];
                    foreach ($classroom_details as $key => $value) {
                        $aprove = 0;
                        if($value->status == "aprove"){
                            $aprove = 1;
                        }
                        $classdetails = Classroom::where(['id' => $value->class_id])->first();

                        $getuser_details = User::where(['id' => $value->user_id])->first();

                        $profile_path='';
                        if($getuser_details->profile_photo_path){
                          $profile_path =   config('ramdoot.appurl')."/upload/profile/".$getuser_details->profile_photo_path;
                        }

                        $check_student_assignment = AssignmentStudent::where(['assignment_id' => $check_assignment->id,'student_id' => $value->user_id])->first();


                        $isAssignmentSent = 0;
                        if($check_student_assignment != null){

                            $check_assignment_submission = AssignmentSubmission::where(['assignment_id' => $check_assignment->id,'user_id' => $value->user_id])->first();

                            if($check_assignment_submission){
                                if($check_assignment_submission->is_submit ==  3){
                                    $isAssignmentSent = 3;
                                }
                                elseif ($check_assignment_submission->is_submit ==  1){
                                    $isAssignmentSent = 2;
                                }
                                else{
                                    $isAssignmentSent = 1;
                                }    
                            }
                            else{
                                $isAssignmentSent = 1;
                            }

                            
                            
                        }
                        

                        $classrooms[] = ['id' => $classdetails->id,
                        'user_id' => $value->user_id,'user_name' => 
                        isset($getuser_details->name) ? $getuser_details->name:'','mobile' => 
                        isset($getuser_details->mobile) ? $getuser_details->mobile:'','profile' => $profile_path,
                        'classroom_id' => $classdetails->classroom_id,'status' => $classdetails->status,'is_aprove' => $aprove,'isAssignmentSent' => $isAssignmentSent];
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
                        "message" => "Student not found.",
                    ]); 
                }
                
            }
            else{
                return response()->json([
                    "code" => 400,
                    "message" => "Assignment not found.",
                ]);
            }
            
        }
        else{

            $classroom_details = ClassStudent::where(['class_id' => $request->class_id])
                            ->where('status','!=','reject')->get();

            $classrooms=[];
            if(count($classroom_details) > 0){
                $classrooms=[];
                foreach ($classroom_details as $key => $value) {
                    $aprove = 0;
                    if($value->status == "aprove"){
                        $aprove = 1;
                    }
                    $classdetails = Classroom::where(['id' => $value->class_id])->first();

                    $getuser_details = User::where(['id' => $value->user_id])->first();

                    $profile_path='';
                    if($getuser_details->profile_photo_path){
                      $profile_path =   config('ramdoot.appurl')."/upload/profile/".$getuser_details->profile_photo_path;
                    }

                    $classrooms[] = ['id' => $classdetails->id,
                    'user_id' => $value->user_id,'user_name' => 
                    isset($getuser_details->name) ? $getuser_details->name:'','mobile' => 
                    isset($getuser_details->mobile) ? $getuser_details->mobile:'','profile' => $profile_path,
                    'classroom_id' => $classdetails->classroom_id,'status' => $classdetails->status,'is_aprove' => $aprove,'isAssignmentSent' => 0];
                }
            }
            else{
                return response()->json([
                    "code" => 400,
                    "message" => "Student not found.",
                ]); 
            }

            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $classrooms,
            ]);
        }

    }


    public function viewSemesters(Request $request){
        
        $rules = array(
            'class_id' => 'required'
        );
        $messages = array(
            'class_id' => 'Please enter class id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $check_class = Classroom::where(['id' => $request->class_id,'status' => 'Active'])->first();

        if($check_class){
            $getsemester = Semester::where(['subject_id' => $check_class->subject_id])->get();
            if(count($getsemester) > 0){
                return response()->json([
                    "code" => 200,
                    "message" => "success",
                    "data" => $getsemester,
                ]);
                
            }else{
                return response()->json([
                    "code" => 400,
                    "message" => "Class not found.",
                ]);
            }
        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "Class not found.",
            ]);
        }
    }

    public function viewUnits(Request $request){
        $rules = array(
            'class_id' => 'required',
            'semester_id' => 'required',
        );
        $messages = array(
            'class_id' => 'Please enter class id.',
            'semester_id' => 'Please enter semester id'
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkclass = Classroom::where(['id' => $request->class_id,'status' => 'Active'])->first();
        $chksemester = Semester::where(['id' => $request->semester_id,'status' => 'Active'])->first();

        if(empty($chkclass)){
            return response()->json([
                "code" => 400,
                "message" => "Class not found.",
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
            $get_unit = Unit::where(['semester_id' => $request->semester_id])->get();

            if(count($get_unit) > 0){
                return response()->json([
                    "code" => 200,
                    "message" => "success",
                    "data" => $get_unit,
                ]);
                
            }else{
                return response()->json([
                    "code" => 400,
                    "message" => "Unit not found.",
                ]);
            }
        }   
    }

    public function viewQuestionCategories(Request $request){
        $rules = array(
            'semester_id' => 'required',
            'unit_id' => 'required',
            'mode' => 'required',
            'class_id' => 'required',
        );
        $messages = array(
            'semester_id' => 'Please enter semester id.',
            'unit_id' => 'Please enter unit id.',
            'mode' => 'Please enter mode.',
            'class_id' => 'Please enter class id.',
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chksemester = Semester::where(['id' => $request->semester_id,'status' => 'Active'])->first();
        $chkunit = Unit::where(['id' => $request->unit_id,'status' => 'Active'])->first();
        $check_class = Classroom::where(['id' => $request->class_id,'status' => 'Active'])->first();

        if(empty($chksemester)){
            return response()->json([
                "code" => 400,
                "message" => "Semester not found.",
                "data" => [],
            ]);
        }
        elseif (empty($chkunit)) {
            return response()->json([
                "code" => 400,
                "message" => "Unit not found.",
                "data" => [],
            ]);
        }
        elseif (empty($check_class)) {
            return response()->json([
                "code" => 400,
                "message" => "Classroom not found.",
                "data" => [],
            ]);
        }
        else{
            $get_unit = Solution::where(['semester_id' => $request->semester_id,'unit_id' => $request->unit_id])->groupby('question_type')->get();
            
            $get_question_type=[];
            foreach ($get_unit as $key => $value) {
                //dd($get_unit);
                // $getquestion_details = QuestionType::select('id','question_type')->where(['id' => $value->question_type])->first();
                
                $get_exits_question = VirtualAssignmentQuestions::where(['class_id' => $request->class_id,'mode' => $request->mode])->get();
                
                $question_arr=[];
                if(count($get_exits_question) > 0){
                    foreach ($get_exits_question as $key_old => $value_old) {
                        $question_arr[] = $value_old->question_id;
                    }    
                }
                
                $get_question_count = Solution::where(['question_type' => $value->question_type])->whereNotIn('id', $question_arr)->count('id');    
                //dd($get_question_count);
                
                $get_mark = Solution::where(['question_type' => $value->question_type])->first();    

                $get_question_type[] = ['question_type' => $value->question_type,'question_count' => $get_question_count,'mark' => isset($get_mark->marks) ? $get_mark->marks:0]; //$getquestion_details;
            }
            $mcqdetails = ['question_type' => "MCQ",'question_count' => 0,'mark' => 0];
            array_push($get_question_type,$mcqdetails);

            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $get_question_type,
            ]);
        }
    }

    public function viewQuestions(Request $request){
        $rules = array(
            'unit_id' => 'required',
            'category_id' => 'required',
            'mode' => 'required',
            'class_id' => 'required',
        );
        $messages = array(
            'unit_id' => 'Please enter unit id.',
            'category_id' => 'Please enter category id.',
            'mode' => 'Please enter mode.',
            'class_id' => 'Please enter class id.',
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkunit = Unit::where(['id' => $request->unit_id,'status' => 'Active'])->first();
        $check_class = Classroom::where(['id' => $request->class_id,'status' => 'Active'])->first();

        // if($request->category_id != 0){
        //     $chkquestiontype = QuestionType::where(['id' => $request->category_id,'status' => 'Active'])->first();    
        // }
        

        if(empty($chkunit)){
            return response()->json([
                "code" => 400,
                "message" => "Unit not found.",
                "data" => [],
            ]);
        }
        elseif (empty($check_class)) {
            return response()->json([
                "code" => 400,
                "message" => "Classroom not found.",
                "data" => [],
            ]);
        }
        else{

            $get_exits_question = VirtualAssignmentQuestions::where(['class_id' => $request->class_id,'mode' => $request->mode])
            ->get();
            $question_arr=[];
            foreach ($get_exits_question as $key_old => $value_old) {
                $question_arr[] = $value_old->question_id;
            }

            if($request->category_id){

                // if(empty($chkquestiontype)){
                //     return response()->json([
                //         "code" => 400,
                //         "message" => "Category not found.",
                //         "data" => [],
                //     ]);    
                // }
                // else{
                    $get_question = Solution::where(['unit_id' => $request->unit_id,'question_type' => $request->category_id])->whereNotIn('id', $question_arr)->get();
                    return response()->json([
                        "code" => 200,
                        "message" => "success",
                        "data" => $get_question,
                    ]);
                // }
            }
            else{
                $get_question = Question::where(['unit_id' => $request->unit_id])->whereNotIn('id', $question_arr)->get();
                return response()->json([
                    "code" => 200,
                    "message" => "success",
                    "data" => $get_question,
                ]);
                
            }
        }
    }

    public function addQuestions(Request $request){

        //dd($request->all());

        $rules = array(
            'class_id' => 'required',
            'assignment_type' => 'required',
            'question_ids' => 'required',
            'question_type' => 'required',
            'mark_ids' => 'required',
            'is_mcq' => 'required',
            'mode' => 'required',
        );
        $messages = array(
            'class_id' => 'Please enter class id.',
            'assignment_type' => 'Please enter assignment type.',
            'question_ids' => 'Please enter question ids.',
            'question_type' => 'Please enter question type.',
            'mark_ids' => 'Please enter mark ids.',
            'is_mcq' => 'Please enter mcq status.',
            'mode' => 'Please enter mode',
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $get_question_arr = explode(',',$request->question_ids);
        $get_mark_arr = explode(',',$request->mark_ids);
        
        for ($i=0; $i < count($get_question_arr); $i++) { 
            
            $add = new VirtualAssignmentQuestions;
            $add->class_id = $request->class_id;
            $add->assignment_type = $request->assignment_type;
            $add->question_id = $get_question_arr[$i];
            $add->question_type = $request->question_type;
            $add->is_mcq = $request->is_mcq;
            $add->mode = $request->mode;
            $add->marks = $get_mark_arr[$i];
            $add->save();
        }

        return response()->json([
            "code" => 200,
            "message" => "success",
        ]);
        

    }

    public function questionCounter(Request $request){

        $rules = array(
            'class_id' => 'required',
            'assignment_type' => 'required',
            'mode' => 'required',
        );
        $messages = array(
            'class_id' => 'Please enter class id.',
            'assignment_type' => 'Please enter assignment id.',
            'mode' => 'Please enter mode.',
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $get_question_details = VirtualAssignmentQuestions::where(['class_id' => $request->class_id,'assignment_type' => $request->assignment_type,'mode' => $request->mode])->groupby('marks')->get();

        if(count($get_question_details) > 0){
            $counter_array=[];
            foreach ($get_question_details as $key => $value) {
               $getcount = VirtualAssignmentQuestions::where(['class_id' => $value->class_id,'marks' => $value->marks,'assignment_type' => $value->assignment_type,'mode' => $request->mode])->count('id');
               $counter_array[] = ['marks' => $value->marks,'count' => $getcount];
            }
            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $counter_array,
            ]);
        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "count not found.",
                "data" => [],
            ]);
        }   
    }

    public function reviewQuestions(Request $request){
        $rules = array(
            'class_id' => 'required',
            'assignment_type' => 'required',
            'mode' => 'required',
        );
        $messages = array(
            'class_id' => 'Please enter class id.',
            'assignment_type' => 'Please enter assignment id.',
            'mode' => 'Please enter mode.',
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $get_question_details = VirtualAssignmentQuestions::with('questionType')->where(['class_id' => $request->class_id,'assignment_type' => $request->assignment_type,'mode' => $request->mode])->groupby('marks')->get();

        if(count($get_question_details) > 0){
            $counter_array=[];
            foreach ($get_question_details as $key => $value) {

                if($value->question_type != null || $value->is_mcq == 0){
                     $vquestions = VirtualAssignmentQuestions::where(['class_id' => $value->class_id,'marks' => $value->marks,'assignment_type' => $value->assignment_type,'mode' => $request->mode])->pluck('question_id')->toArray();
                     //dd($vquestions);     
                     $questions = Solution::whereIn('id',$vquestions)->get();
                     $question_arr=[];
                     foreach ($questions as $key_question => $value_question) {
                        
                        $get_vquestions_id = VirtualAssignmentQuestions::where(['question_id' => $value_question->id,'class_id' => $value->class_id,'mode' => $request->mode])->first();
                        
                         $question_arr[] = Solution::where(['id' => $value_question->id])->select('*',DB::raw("CONCAT('$get_vquestions_id->id') AS virtual_assignment_question_id"))->first();
                     }
                }    
                else{
                    $vmquestions = VirtualAssignmentQuestions::with('question')->where(['class_id' => $value->class_id,'marks' => $value->marks,'assignment_type' => $value->assignment_type,'mode' => $request->mode])->pluck('question_id')->toArray();
                    $questions = Solution::whereIn('id',$vmquestions)->get();
                    $question_arr=[];
                     foreach ($questions as $key_question => $value_question) {
                        
                        $get_vquestions_id = VirtualAssignmentQuestions::where(['question_id' => $value_question->id,'class_id' => $value->class_id,'mode' => $request->mode])->first();
                        
                         $question_arr[] = Solution::where(['id' => $value_question->id])->select('*',DB::raw("CONCAT('$get_vquestions_id->id') AS virtual_assignment_question_id"))->first();
                     }
                }                                
                $question_array[] = ['id' => $value->id,'class_id' => $value->class_id,'mode' => $value->mode,'assignment_type' => $value->assignment_type,'question_type' => $value->question_type,'is_mcq' => $value->is_mcq,'marks' => $value->marks,'question_solution' => $question_arr]; //,'question_type_id' => $value->questionType->id,'question_type' => $value->questionType->question_type
            }
            
            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $question_array,
            ]);
        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "Question not found.",
                "data" => [],
            ]);
        }

    }

    public function generateAssignment(Request $request){

        $rules = array(
            'class_id' => 'required',
            'assignment_type' => 'required',
        );
        $messages = array(
            'class_id' => 'Please enter class id.',
            'assignment_type' => 'Please enter assignment id.',
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $new_name=null;
        if($request->has('assignment_image'))
        {
        
            $image = $request->file('assignment_image');
            $url = public_path('upload/assignment_image/');
            $originalPath = $url;
            $name = time() . mt_rand(10000, 99999);
            $new_name = $name . '.' . $image->getClientOriginalExtension();
            $image->move($originalPath, $new_name);           
        }

        $add = new Assignment;
        $add->user_id = $request->user_id;
        $add->class_id = $request->class_id;
        $add->assignment_type = $request->assignment_type;
        $add->subject_id = $request->subject_id;
        $add->mode = $request->mode;
        $add->title = $request->title;
        $add->assignment_details = $request->assignment_details;
        $add->assignment_date = $request->assignment_date;
        $add->assignment_time = $request->assignment_time;
        $add->due_date = $request->due_date;
        $add->due_time = $request->due_time;
        $add->total_questions = $request->total_questions;
        $add->total_marks = $request->total_marks;
        $add->assignment_option = $request->assignment_option;
        $add->assignment_image = $new_name;
        $add->instruction = isset($request->instruction) ? $request->instruction:null;
        $add->save();

        $get_question = explode(',',$request->question_id);
        $get_unit = explode(',',$request->unit_id);
        $get_semester_id = explode(',',$request->semester_id);
        $get_question_type = explode(',',$request->question_type);
        $get_marks = explode(',',$request->marks);
        
        
        if(count($get_question) > 0){
            for ($i=0; $i < count($get_question); $i++) { 
                
                $add_ques = new AssignmentQuestion;
                $add_ques->unit_id = $get_unit[$i];
                $add_ques->semester_id = $get_semester_id[$i];
                $add_ques->question_type = $get_question_type[$i];
                $add_ques->assignment_id = $add->id;
                $add_ques->question_id = $get_question[$i];
                $add_ques->marks = $get_marks[$i];
                $add_ques->save();
            }    
        }

        if($request->has('documents')){
            for ($doc=0; $doc < count($request->documents); $doc++) {

                $image = $request->documents[$doc];
                $url = public_path('upload/assignment_document/');
                $originalPath = $url;
                $name = time() . mt_rand(10000, 99999);
                $new_name = $name . '.' . $image->getClientOriginalExtension();
                $image->move($originalPath, $new_name);

                $add_doc = new TeacherAssignmentDocument;
                $add_doc->teacher_assignment_id = $add->id;
                $add_doc->document = $new_name;
                $add_doc->save();
                           
            }    
        }

        VirtualAssignmentQuestions::where(['class_id'=> $request->class_id,'mode' => $request->mode])->delete();
        
        return response()->json([
            "code" => 200,
            "message" => "success",
        ]);
    }

    public function assignmentList(Request $request){

        $rules = array(
            'class_id' => 'required',
            'student_id' => 'required',
        );
        $messages = array(
            'class_id' => 'Please enter class id.',
            'student_id' => 'Please enter Student id.',
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $check_class = Classroom::where(['id' => $request->class_id,'status' => 'Active'])->first();

        if($check_class){

            if($request->student_id != "0"){

                $check_student = User::where(['id' => $request->student_id])->first();
                
                if($check_student){

                    $get_student_assignment = AssignmentStudent::where(['student_id' => $request->student_id])->get();
                   // dd(count($get_student_assignment));
                   // $assignment_details = Assignment::with('assignment_question')->where(['user_id' => ])->get();
                    $assignment=[];
                    if(count($get_student_assignment) > 0){
                        foreach ($get_student_assignment as $key => $value) {

                            $assig_data = Assignment::where(['id' => $value->assignment_id,'class_id' => $request->class_id,'status' => 'Active'])->first();
                           
                           
                           if($assig_data){

                                $get_document = TeacherAssignmentDocument::where(['teacher_assignment_id' => $assig_data->id])->get();
                                $assignment_document=[];
                                foreach ($get_document as $key_sub_doc => $value_sub_doc) {
                                    $doc_path='';
                                    if($value_sub_doc->document){
                                        $doc_path =   config('ramdoot.appurl')."/upload/assignment_document/".$value_sub_doc->document;
                                    }
                                    $assignment_document[] = ['id' => $value_sub_doc->id,'teacher_assignment_id' => $value_sub_doc->teacher_assignment_id,'document' => $doc_path,'created_at' => $value_sub_doc->created_at,'updated_at' => $value_sub_doc->updated_at,];         
                                }


                                $media_assignment_check = AssignmentSubmission::where(['assignment_id' => $assig_data->id,'user_id' => $request->student_id])->first();

                                $media_assignment=[];
                                if($media_assignment_check){
                                   
                                    if($media_assignment_check->question_id == 0){
                                        $media_assignment_details = AssignmentSubmission::where(['id' => $media_assignment_check->id])->get();

                                        foreach ($media_assignment_details as $key_media_assignment => $value_media_assignment) {

                                            $get_doc = AssignmentDocument::where(['assignment_submission_id' => $value_media_assignment->id])->get();
                                            $assignment_documents=[];
                                            foreach ($get_doc as $key_get_doc => $value_get_doc) {
                                                $doc_path='';
                                                if($value_get_doc->document){
                                                    $doc_path =   config('ramdoot.appurl')."/upload/assignment_document/".$value_get_doc->document;
                                                }

                                                $assignment_documents[] = ['id' => $value_get_doc->id,'assignment_submission_id' => $value_get_doc->assignment_submission_id,'document' => $doc_path,'created_at' => $value_get_doc->created_at,'updated_at' => $value_get_doc->updated_at];
                                            }

                                           $media_assignment[] = ['id' => $value_media_assignment->id,'user_id' => $value_media_assignment->user_id,'assignment_id' => $value_media_assignment->assignment_id,'question_id' => $value_media_assignment->question_id,'answer' => $value_media_assignment->answer,'created_at' => $value_media_assignment->created_at,'updated_at' => $value_media_assignment->updated_at,'assignment_documents' => $assignment_documents];
                                        }
                                    }
                                }

                                $total_submission =  0; 
                                $total_reviews = 0;
                                $total_assignment_sent = 0;
                               $assignment_img = '';
                               if($assig_data->assignment_image){
                                $assignment_img =  config('ramdoot.appurl')."/upload/assignment_image/".$assig_data->assignment_image;
                                }
                                $is_submited=0;
                                $assignment_submission_created_at='';
                                $assignment_submission_updated_at='';

                                $get_assignment_question = AssignmentQuestion::with('question')->where(['assignment_id' => $assig_data->id])->get();
                                $assignment_question=[];$is_submit=0;$media_question=[];
                                if(count($get_assignment_question) > 0){

                                    foreach ($get_assignment_question as $key_assignment => $value_assignment) {

                                        $check_submit_question = AssignmentSubmission::where(['user_id' => $request->student_id,'assignment_id' => $value->assignment_id,'question_id' => $value_assignment->question_id])->first();

                                        $is_submited = 0;
                                        if($check_submit_question){
                                            $is_submited = 1;
                                        }


                                        $media_question_check = AssignmentSubmission::where(['assignment_id' => $assig_data->id,'user_id' => $request->student_id,'question_id' => $value_assignment->question_id])->first();

                                        
                                        if($media_question_check){
                                           
                                            // if($media_question_check->question_id != 0){
                                            //     $media_question = AssignmentSubmission::with('assignment_document')->where(['id' => $media_question_check->id,'question_id' => $media_question_check->question_id])->get();
                                            // }

                                           // $media_question_check = AssignmentSubmission::where(['assignment_id' => $assig_data->id,'user_id' => $request->student_id])->first();
                                            //  dd($media_question_check);

                                            //if($media_question_check){

                                                $is_submit = $media_question_check->is_submit;
                                                $assignment_submission_created_at = $media_question_check->created_at;
                                                $assignment_submission_updated_at = $media_question_check->updated_at;

                                                if($media_question_check->question_id != 0){

                                                    $media_question_details = AssignmentSubmission::where(['id' => $media_question_check->id,'question_id' =>$media_question_check->question_id])->get();
                                                }
                                                else{
                                                    $media_question_details = AssignmentSubmission::where(['id' => $media_question_check->id])->get();
                                                }  
                                                
                                                $media_question=[];
                                                foreach ($media_question_details as $key_media_question => 
                                                    $value_media_question) 
                                                {

                                                        $get_doc = AssignmentDocument::where(['assignment_submission_id' => $value_media_question->id])->get();

                                                        $assignment_documents_question=[];
                                                        foreach ($get_doc as $key_get_doc => $value_get_doc) {
                                                            $doc_path='';
                                                            if($value_get_doc->document){
                                                                $doc_path =   config('ramdoot.appurl')."/upload/assignment_document/".$value_get_doc->document;
                                                            }

                                                            $assignment_documents_question[] = ['id' => $value_get_doc->id,'assignment_submission_id' => $value_get_doc->assignment_submission_id,'document' => $doc_path,'created_at' => $value_get_doc->created_at,'updated_at' => $value_get_doc->updated_at];
                                                        }


                                                       $media_question[] = ['id' => $value_media_question->id,'user_id' => $value_media_question->user_id,'assignment_id' => $value_media_question->assignment_id,'question_id' => $value_media_question->question_id,'answer' => $value_media_question->answer,'created_at' => $value_media_question->created_at,'updated_at' => $value_media_question->updated_at,'assignment_documents' => $assignment_documents_question];
                                                }
                                                    
                                                
                                           // }

                                        }
                                        else{
                                            $media_question=[];
                                        }

                                        




                                        // if($assig_data->question_id != 0){
                                        //     $media_question = AssignmentSubmission::with('assignment_document')->where(['assignment_id' => $assig_data->id,'question_id' => 
                                        //         $value_assignment->question_id])->get();
                                                   
                                        // }

                                     

                                        $assignment_question[] = ['id' => $value_assignment->id,'assignment_id' => $value_assignment->assignment_id,'semester_id' => $value_assignment->semester_id,'unit_id' => $value_assignment->unit_id,'question_id' => $value_assignment->question_id,'question_type' => $value_assignment->question_type,'marks' => $value_assignment->marks,'created_at' => $value_assignment->created_at,'updated_at' => $value_assignment->updated_at,'is_submited' => $is_submited,'media' => $media_question,'question' => $value_assignment->question];
                                    }    
                                }

                                $get_dates = AssignmentStudent::where(['student_id' => $request->student_id,'assignment_id' => $assig_data->id])->first();
                                
                                $assignment_assign_date='';$assignment_submission_date='';$assignment_review_date='';
                                if($get_dates){

                                    $assignment_assign_date=$get_dates->created_at;
                                    $assignment_submission_date=isset($get_dates->student_submission_date) ? $get_dates->student_submission_date:'';
                                    $assignment_review_date=isset($get_dates->teacher_submission_date) ? $get_dates->teacher_submission_date:'';
                                }

                                $assignment[] = ['id' => $assig_data->id,'user_id' => $assig_data->user_id,'class_id' => $assig_data->class_id,'assignment_type' => $assig_data->assignment_type,'subject_id' => $assig_data->subject_id,'mode' => $assig_data->mode,'title' => $assig_data->title,'assignment_details' => $assig_data->assignment_details,'assignment_date' => $assig_data->assignment_date,'assignment_time' => $assig_data->assignment_time,'due_date' => $assig_data->due_date,'due_time' => $assig_data->due_time,'total_questions' => $assig_data->total_questions,'total_marks' => $assig_data->total_marks,'assignment_image' => $assig_data->assignment_image,'assignment_option' => $assig_data->assignment_option,'water_mark' => $assig_data->water_mark,'footer' => $assig_data->footer,'instruction' => $assig_data->instruction,'font_size' => $assig_data->font_size,'marks_on' => $assig_data->marks_on,'created_at' => $assig_data->created_at,'updated_at' => $assig_data->updated_at,'total_submission' => $total_submission,'total_review' => $total_reviews,'total_assignment_sent' => $total_assignment_sent,'is_submit' => $is_submit,'assignment_created_at' => $assignment_submission_created_at,'assignment_updated_at' => $assignment_submission_updated_at,'assignment_assign_date' => $assignment_assign_date,'assignment_submission_date' => $assignment_submission_date,'assignment_review_date' => $assignment_review_date,'assignment_image_url' => 
                                    $assignment_img,'assignment_document' => $assignment_document,'media' => $media_assignment,'assignment_question' => $assignment_question];

                                // $assignment[] = Assignment::with('assignment_question','assignment_question.question')->where('id',$assig_data->id)->select('*',DB::raw("CONCAT('$total_submission') AS total_submission"),DB::raw("CONCAT('$assignment_img') AS assignment_image_url"))->first(); 
                           } 
                           
                        }
                    }
                    arsort($assignment);
                    $assignmentdata=[];
                    foreach ($assignment as $key_assignment => $value_assignment) {
                        $assignmentdata[] = $value_assignment;
                    }
                    return response()->json([
                        "code" => 200,
                        "message" => "success",
                        "data" => $assignmentdata,
                    ]);
                }
                else{
                    return response()->json([
                        "code" => 400,
                        "message" => "Student not found.",
                        "data" => [],
                    ]);
                }

                

            }else{

                $assignment_details = Assignment::with('assignment_question')->where(['class_id' => $request->class_id,
                    'status' => 'Active'])->get();
                $assignment=[];
                if(count($assignment_details) > 0){
                    foreach ($assignment_details as $key => $value) {
                        

                        $get_total_submission = AssignmentSubmission::where(['assignment_id' => $value->id,'is_submit' => 1])->groupby('user_id')->get()->count();

                        $get_total_reviews = AssignmentSubmission::where(['assignment_id' => $value->id,'is_submit' => 3])->groupby('user_id')->get()->count();

                        
                        $get_assignment_sent_count = AssignmentStudent::where(['assignment_id' => $value->id])->get()->count();

                       $total_submission =  $get_total_submission;
                       $total_reviews =  $get_total_reviews; 
                       $total_assignment_sent = $get_assignment_sent_count;
                       $assignment_img = '';
                       $is_submit = 0;
                       $assignment_submission_created_at='';
                       $assignment_submission_updated_at='';
                       if($value->assignment_image){
                        $assignment_img =  config('ramdoot.appurl')."/upload/assignment_image/".$value->assignment_image;
                        }

                        $get_assignment_question = AssignmentQuestion::with('question')->where(['assignment_id' => $value->id])->get();
                        $question_array=[];
                        foreach ($get_assignment_question as $key_assignment_question => $value_assignment_question) {
                            $question_array[]= $value_assignment_question;
                        }


                        $get_document = TeacherAssignmentDocument::where(['teacher_assignment_id' => $value->id])->get();
                        $assignment_document=[];
                        foreach ($get_document as $key_sub_doc => $value_sub_doc) {
                            $doc_path='';
                            if($value_sub_doc->document){
                                $doc_path =   config('ramdoot.appurl')."/upload/assignment_document/".$value_sub_doc->document;
                            }
                            $assignment_document[] = ['id' => $value_sub_doc->id,'teacher_assignment_id' => $value_sub_doc->teacher_assignment_id,'document' => $doc_path,'created_at' => $value_sub_doc->created_at,'updated_at' => $value_sub_doc->updated_at,];         
                        }

                        $assignment_assign_date='';$assignment_submission_date='';$assignment_review_date='';
                        $assignment[] = ['id' => $value->id,'user_id' => $value->user_id,'class_id' => $value->class_id,'assignment_type' => $value->assignment_type,'subject_id' => $value->subject_id,'mode' => $value->mode,'title' => $value->title,'assignment_details' => $value->assignment_details,'assignment_date' => $value->assignment_date,'assignment_time' => $value->assignment_time,'due_date' => $value->due_date,'due_time' => $value->due_time,'total_questions' => $value->total_questions,'total_marks' => $value->total_marks,'assignment_image' => $assignment_img,'assignment_option' => $value->assignment_option,'water_mark' => $value->water_mark,'footer' => $value->footer,'instruction' => $value->instruction,'font_size' => $value->font_size,'marks_on' => $value->marks_on,'created_at' => $value->created_at,'updated_at' => $value->updated_at,'total_submission' => $total_submission,'total_review' => $total_reviews,'total_assignment_sent' => $total_assignment_sent,'is_submit' => $is_submit,'assignment_created_at' => $assignment_submission_created_at,'assignment_updated_at' =>  $assignment_submission_updated_at,'assignment_assign_date' => $assignment_assign_date,'assignment_submission_date' => $assignment_submission_date,'assignment_review_date' => $assignment_review_date,'assignment_document' => $assignment_document,'assignment_question' => $question_array];

                       //$assignment[] = Assignment::with('assignment_question','assignment_question.question')->where('id',$value->id)->select('*',DB::raw("CONCAT('$total_submission') AS total_submission"),DB::raw("CONCAT('$is_submit') AS is_submit"),DB::raw("CONCAT('$assignment_img') AS assignment_image_url"))->first();
                    }
                }

                return response()->json([
                    "code" => 200,
                    "message" => "success",
                    "data" => $assignment,
                ]);
            }

            

        }
        else{

            return response()->json([
                "code" => 400,
                "message" => "Class not found.",
                "data" => [],
            ]);
        }
    }

    public function assignmentStudent(Request $request){

        $rules = array(
            'assignment_id' => 'required',
            'student_ids' => 'required',
        );
        $messages = array(
            'assignment_id' => 'Please enter assignment id.',
            'student_ids' => 'Please enter student id.'
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }
        $get_student = explode(',',$request->student_ids);
        
        $check_assignment = Assignment::where(['id' => $request->assignment_id,'status' => 'Active'])->first();
        //$check_assignment = TeacherAssignment::where(['id' => $request->assignment_id])->first();        
        if($check_assignment){
            if(count($get_student) > 0){
                for ($i=0; $i < count($get_student); $i++) { 
                    $add_ques = new AssignmentStudent;
                    $add_ques->assignment_id = $request->assignment_id;
                    $add_ques->student_id = $get_student[$i];
                    $add_ques->save();

                    
                    $get_class_details = Classroom::where(['id' => $check_assignment->class_id,'status' => 'Active'])->first();
                    $subject_name = isset($get_class_details->subject->subject_name) ? $get_class_details->subject->subject_name:'';
                    $standard_name = isset($get_class_details->standard->standard) ? $get_class_details->standard->standard:'';
                    $student_details = User::where(['id' => $get_student[$i]])->first();
                    $student_name = isset($student_details->name) ? $student_details->name:'';
                    $title_details = isset($check_assignment->assignment_type) ? $check_assignment->assignment_type:'';

                    $medium_details = Medium::where(['id' => $get_class_details->medium_id])->first();

                    if($medium_details->sub_title == "GUJARATI_MEDIUM"){  
                        $title = $title_details;

                        $message = "કેમ છો? ".$student_name.", મજામાં...??\n".date('d/m/Y, l').". ના રોજ ધોરણ:- ".$standard_name." માં આજનો અભ્યાસનો વિષય:- ".$subject_name." રહેશે.\n👉Go to Classroom માં ".$subject_name." વિષયમાં તમને અપાયેલ સૂચન મુજબ આજનું ".$title_details." કરો.";
                    }
                    else{
                        
                        $title = $title_details;

                        $message = "How are you? ".$student_name."\nToday ".date('d/m/Y, l').".\nToday's subject will be ".
                        $subject_name." in class ".$standard_name.".\n👉 For today's homework Go to classroom>".$subject_name.">".$title_details.".";
                    }
                    send_notifications($get_student[$i], $message, $title);
                }

                return response()->json([
                    "code" => 200,
                    "message" => "success"
                ]);    
            }   
        }
        else
        {
            return response()->json([
                "code" => 400,
                "message" => "Assignment not found.",
                "data" => [],
            ]);
        }
   
    }

    public function assignmentSubmission(Request $request){
        $rules = array(
            'user_id' => 'required',
            'assignment_id' => 'required',
           // / 'document' => 'required',
            'question_id' => 'required',
            //'answer' => 'required',
        );
        $messages = array(
            'user_id' => 'Please enter user id',
            'assignment_id' => 'Please enter assignment id.',
         //   'document' => 'Please select document.',
            'question_id' => 'Please enter question id.',
          //  'answer' => 'Please enter answer.',
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        if($request->question_id != "0"){

            $check_assignment = AssignmentSubmission::where(['user_id' => $request->user_id,'assignment_id' => $request->assignment_id,'question_id' => $request->question_id])->first();

            if($check_assignment){

                $add = AssignmentSubmission::find($check_assignment->id);
                $add->user_id = $request->user_id;
                $add->assignment_id = $request->assignment_id;
                $add->question_id = $request->question_id;
                $add->answer = $request->answer;
                $add->save();   

                if($request->has('document')){
                    for ($doc=0; $doc < count($request->document); $doc++) {

                        $image = $request->document[$doc];
                        $url = public_path('upload/assignment_document/');
                        $originalPath = $url;
                        $name = time() . mt_rand(10000, 99999);
                        $new_name = $name . '.' . $image->getClientOriginalExtension();
                        $image->move($originalPath, $new_name);

                        $add_doc = new AssignmentDocument;
                        $add_doc->assignment_submission_id = $add->id;
                        $add_doc->document = $new_name;
                        $add_doc->save();
                                   
                    }    
                }
                
                
                    
            }
            else{

                $add = new AssignmentSubmission;
                $add->user_id = $request->user_id;
                $add->assignment_id = $request->assignment_id;
                $add->question_id = $request->question_id;
                $add->answer = $request->answer;
                $add->save();   

                if($request->has('document')){
                    for ($doc=0; $doc < count($request->document); $doc++) {

                        $image = $request->document[$doc];
                        $url = public_path('upload/assignment_document/');
                        $originalPath = $url;
                        $name = time() . mt_rand(10000, 99999);
                        $new_name = $name . '.' . $image->getClientOriginalExtension();
                        $image->move($originalPath, $new_name);

                        $add_doc = new AssignmentDocument;
                        $add_doc->assignment_submission_id = $add->id;
                        $add_doc->document = $new_name;
                        $add_doc->save();
                                   
                    }
                }
                
            }

            $get_assignment_data = AssignmentSubmission::where(['id' => $add->id])->first();
            $get_doc = AssignmentDocument::where(['assignment_submission_id' => $add->id])->get();
            //dd(count($get_doc));

            $assignment_documents_question=[];
            foreach ($get_doc as $key_get_doc => $value_get_doc) {
                $doc_path='';
                if($value_get_doc->document){
                    $doc_path =   config('ramdoot.appurl')."/upload/assignment_document/".$value_get_doc->document;
                }

                $assignment_documents_question[] = ['id' => $value_get_doc->id,'assignment_submission_id' => $value_get_doc->assignment_submission_id,'document' => $doc_path,'created_at' => $value_get_doc->created_at,'updated_at' => $value_get_doc->updated_at];
            }
            
            $assignment=[];
            if($get_assignment_data){

                $assignment[] = ['assignment_document' => $assignment_documents_question];                    
            }
            


            return response()->json([
                "code" => 200,
                "message" => "success",
                'data' => $assignment,
            ]);
        }
        else{
            $check_assignment = AssignmentSubmission::where(['user_id' => $request->user_id,'assignment_id' => $request->assignment_id,'question_id' => 0])->first();
            if($check_assignment){
                $add = AssignmentSubmission::find($check_assignment->id);
                $add->user_id = $request->user_id;
                $add->assignment_id = $request->assignment_id;
                $add->question_id = 0;
                $add->answer = $request->answer;
                $add->save();   

                if($request->has('document')){

                    for ($doc=0; $doc < count($request->document); $doc++) {

                        $image = $request->document[$doc];
                        $url = public_path('upload/assignment_document/');
                        $originalPath = $url;
                        $name = time() . mt_rand(10000, 99999);
                        $new_name = $name . '.' . $image->getClientOriginalExtension();
                        $image->move($originalPath, $new_name);

                        $add_doc = new AssignmentDocument;
                        $add_doc->assignment_submission_id = $add->id;
                        $add_doc->document = $new_name;
                        $add_doc->save();
                                   
                    }
                }
            }
            else{
                $add = new AssignmentSubmission;
                $add->user_id = $request->user_id;
                $add->assignment_id = $request->assignment_id;
                $add->question_id = 0;
                $add->answer = $request->answer;
                $add->save();   

                if($request->has('document')){

                    for ($doc=0; $doc < count($request->document); $doc++) {

                        $image = $request->document[$doc];
                        $url = public_path('upload/assignment_document/');
                        $originalPath = $url;
                        $name = time() . mt_rand(10000, 99999);
                        $new_name = $name . '.' . $image->getClientOriginalExtension();
                        $image->move($originalPath, $new_name);

                        $add_doc = new AssignmentDocument;
                        $add_doc->assignment_submission_id = $add->id;
                        $add_doc->document = $new_name;
                        $add_doc->save();
                                   
                    }
                }
            }

            $get_assignment_data = AssignmentSubmission::where(['id' => $add->id])->first();
            $get_doc = AssignmentDocument::where(['assignment_submission_id' => $add->id])->get();
            //dd(count($get_doc));

            $assignment_documents_question=[];
            foreach ($get_doc as $key_get_doc => $value_get_doc) {
                $doc_path='';
                if($value_get_doc->document){
                    $doc_path =   config('ramdoot.appurl')."/upload/assignment_document/".$value_get_doc->document;
                }

                $assignment_documents_question[] = ['id' => $value_get_doc->id,'assignment_submission_id' => $value_get_doc->assignment_submission_id,'document' => $doc_path,'created_at' => $value_get_doc->created_at,'updated_at' => $value_get_doc->updated_at];
            }
            
            $assignment=[];
            if($get_assignment_data){

                $assignment[] = ['assignment_document' => $assignment_documents_question];                    
            }
            

            return response()->json([
                "code" => 200,
                "message" => "success",
                'data' => $assignment,
            ]);
        }

    }

    public function finalAssignmentSubmission(Request $request){

        $rules = array(
            'assignment_id' => 'required',
            'user_id' => 'required',
        );
        $messages = array(
            'assignment_id' => 'Please enter assignment id.',
            'user_id' => 'Please enter user id.'
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $check_assignment = AssignmentSubmission::where(['user_id' => $request->user_id,'assignment_id' => $request->assignment_id])->first();

        if($check_assignment){

              $check_student_assignment =  AssignmentStudent::where(['student_id' => $request->user_id,'assignment_id' => $request->assignment_id])->first();
              if($check_student_assignment){
                AssignmentStudent::where(['id' => $check_student_assignment->id])->update(['student_submission_date' => date('Y-m-d H:i:s')]);
              }

            

            AssignmentSubmission::where(['user_id' => $request->user_id,'assignment_id' => $request->assignment_id])->update(['is_submit' => 1]);    


            $student_details = User::where(['id' => $request->user_id])->first();
            $student_name = isset($student_details->name) ? $student_details->name:'';

            $assignment_details = Assignment::where(['id' => $request->assignment_id])->first();

            $teacher_details = User::where(['id' => $assignment_details->user_id])->first();
            $teacher_name = isset($teacher_details->name) ? $teacher_details->name:'';

            $get_class_details = Classroom::where(['id' => $assignment_details->class_id,'status' => 'Active'])->first();

            if($get_class_details){

                $subject_name = isset($get_class_details->subject->subject_name) ? $get_class_details->subject->subject_name:'';
                $standard_name = isset($get_class_details->standard->standard) ? $get_class_details->standard->standard:''; 

                $get_assignment_type = isset($assignment_details->assignment_type) ? $assignment_details->assignment_type:'';
                
                $medium_details = Medium::where(['id' => $get_class_details->medium_id])->first();    

                if($medium_details->sub_title == "GUJARATI_MEDIUM"){
                    $title = "Submit ".$get_assignment_type;
                    $message = "તા.".date('d/m/Y, l')." ના રોજ ધોરણ:- ".$standard_name." માં ".$subject_name." વિષયમાં આપવામાં આવેલ ગૃહકાર્ય ".$student_name." દ્વારા સબમિટ થઈ ગયું છે.";
                }
                else{
                    $title = "Submit ".$get_assignment_type;
                    $message = "Class ".$standard_name.",\n".$subject_name." Assigned On ".date('d/m/Y, l')." is submitted by ".$student_name.".";        
                }
                send_notifications($teacher_details->id, $message, $title);        
            }

            return response()->json([
                "code" => 200,
                "message" => "success"
            ]);
        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "Assignment not found.",
                "data" => [],
            ]);
        }


    }

    public function deleteDocument(Request $request){
        $rules = array(
            'document_id' => 'required'
        );
        $messages = array(
            'document_id' => 'Please enter document id.'
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $check_document = AssignmentDocument::where(['id' => $request->document_id])->first();

        if($check_document){
            AssignmentDocument::where(['id' => $check_document->id])->delete();
            return response()->json([
                "code" => 200,
                "message" => "success"
            ]);            
        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "Assignment document not found.",
                "data" => [],
            ]);
        }
    }

    public function assignmentReviewSubmit(Request $request){

        $rules = array(
            'assignment_id' => 'required',
            'user_id' => 'required',
        );
        $messages = array(
            'assignment_id' => 'Please enter assignment id.',
            'user_id' => 'Please enter user id.'
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $check_assignment = AssignmentSubmission::where(['user_id' => $request->user_id,'assignment_id' => $request->assignment_id])->first();

        if($check_assignment){


            $check_student_assignment =  AssignmentStudent::where(['student_id' => $request->user_id,'assignment_id' => $request->assignment_id])->first();
              if($check_student_assignment){
                AssignmentStudent::where(['id' => $check_student_assignment->id])->update(['teacher_submission_date' => date('Y-m-d H:i:s')]);
              }

            AssignmentSubmission::where(['user_id' => $request->user_id,'assignment_id' => $request->assignment_id])->update(['is_submit' => 3]);


            

            $student_details = User::where(['id' => $request->user_id])->first();
            $student_name = isset($student_details->name) ? $student_details->name:'';

            $assignment_details = Assignment::where(['id' => $request->assignment_id])->first();

            $teacher_details = User::where(['id' => $assignment_details->user_id])->first();
            $teacher_name = isset($teacher_details->name) ? $teacher_details->name:'';
          //  dd($assignment_details);

            $get_class_details = Classroom::where(['id' => $assignment_details->class_id,'status' => 'Active'])->first();

            if($get_class_details){

                $subject_name = isset($get_class_details->subject->subject_name) ? $get_class_details->subject->subject_name:'';
                $standard_name = isset($get_class_details->standard->standard) ? $get_class_details->standard->standard:''; 

                $get_assignment_type = isset($assignment_details->assignment_type) ? $assignment_details->assignment_type:'';
                $medium_details = Medium::where(['id' => $get_class_details->medium_id])->first();

                if($medium_details->sub_title == "GUJARATI_MEDIUM"){
                    $title = "Review ".$get_assignment_type;
                    $message = "કેમ છો?  ".$student_name.", મજામાં...??\n".date('d/m/Y, l')." ના રોજ ધોરણ:- ".$standard_name." માં ".$subject_name." વિષયમાં તમારા દ્વારા સબમિટ કરેલ ગૃહકાર્યનો રિવ્યું રિપોર્ટ તમને ".$teacher_name." એ મોકલ્યો છે.\n👉રિવ્યું રિપોર્ટ જોવા Go to Classroom માં ".$subject_name." વિષયમાં Review માં જવું.";
                }
                else{
                    $title = "Review ".$get_assignment_type;
                    $message = "How are you? ".$student_name.".\n".$subject_name."in class ".$standard_name."Assignment submitted by you on ".date('d/m/Y, l')." is Review by ".$teacher_name.".\n👉 For Seeing the report Go to classroom>".$subject_name.">Review ".$get_assignment_type.".";
                }
                send_notifications($request->user_id, $message, $title);

            }    

            return response()->json([
                "code" => 200,
                "message" => "success"
            ]);
        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "Assignment not found.",
                "data" => [],
            ]);
        }


    }


    public function studentAssignmentDetail(Request $request){
        $rules = array(
            'student_id' => 'required',
            'assignment_id' => 'required'
        );
        $messages = array(
            'student_id' => 'Please enter Student id.',
            'assignment_id' => 'Please enter Assignment id.'
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $check_student = User::where(['id' => $request->student_id])->first();
                
        if($check_student){

            $get_student_assignment = AssignmentStudent::where(['student_id' => $request->student_id,'assignment_id' => $request->assignment_id])->get();
           // $assignment_details = Assignment::with('assignment_question')->where(['user_id' => ])->get();
            $assignment=[];
            if(count($get_student_assignment) > 0){
                foreach ($get_student_assignment as $key => $value) {

                    $assig_data = Assignment::where(['id' => $value->assignment_id,'status' => 'Active'])->first();
                   
                   if($assig_data){

                        $get_document = TeacherAssignmentDocument::where(['teacher_assignment_id' => $assig_data->id])->get();
                        $assignment_document=[];
                        foreach ($get_document as $key_sub_doc => $value_sub_doc) {
                            $doc_path='';
                            if($value_sub_doc->document){
                                $doc_path =   config('ramdoot.appurl')."/upload/assignment_document/".$value_sub_doc->document;
                            }
                            $assignment_document[] = ['id' => $value_sub_doc->id,'teacher_assignment_id' => $value_sub_doc->teacher_assignment_id,'document' => $doc_path,'created_at' => $value_sub_doc->created_at,'updated_at' => $value_sub_doc->updated_at,];         
                        }

                        $media_assignment_check = AssignmentSubmission::where(['assignment_id' => $assig_data->id,'user_id' => $request->student_id])->first();

                        $media_assignment=[];
                        if($media_assignment_check){
                           
                            if($media_assignment_check->question_id == 0){
                                $media_assignment_details = AssignmentSubmission::where(['id' => $media_assignment_check->id])->get();

                                foreach ($media_assignment_details as $key_media_assignment => $value_media_assignment) {

                                    $get_doc = AssignmentDocument::where(['assignment_submission_id' => $value_media_assignment->id])->get();
                                    $assignment_documents=[];
                                    foreach ($get_doc as $key_get_doc => $value_get_doc) {
                                        $doc_path='';
                                        if($value_get_doc->document){
                                            $doc_path =   config('ramdoot.appurl')."/upload/assignment_document/".$value_get_doc->document;
                                        }

                                        $assignment_documents[] = ['id' => $value_get_doc->id,'assignment_submission_id' => $value_get_doc->assignment_submission_id,'document' => $doc_path,'created_at' => $value_get_doc->created_at,'updated_at' => $value_get_doc->updated_at];
                                    }
                                    $media_assignment[] = ['id' => $value_media_assignment->id,'user_id' => $value_media_assignment->user_id,'assignment_id' => $value_media_assignment->assignment_id,'question_id' => $value_media_assignment->question_id,'answer' => $value_media_assignment->answer,'teacher_id' => $value_media_assignment->teacher_id,'marks' => $value_media_assignment->marks,'comment' => $value_media_assignment->comment,'emoji' => $value_media_assignment->emoji,'is_submit' => $value_media_assignment->is_submit,'created_at' => $value_media_assignment->created_at,'updated_at' => $value_media_assignment->updated_at,'assignment_documents' => $assignment_documents];
                                }
                            }
                        }

                        $get_total_submission = AssignmentSubmission::where(['assignment_id' => $assig_data->id,'is_submit' => 1])->groupby('user_id')->get()->count();

                        $get_total_reviews = AssignmentSubmission::where(['assignment_id' => $assig_data->id,'is_submit' => 3])->groupby('user_id')->get()->count();

                        
                        $get_assignment_sent_count = AssignmentStudent::where(['assignment_id' => $assig_data->id])->get()->count();

                       $total_submission =  $get_total_submission;
                       $total_reviews =  $get_total_reviews; 
                       $total_assignment_sent = $get_assignment_sent_count;

                       // $total_submission =  0; 
                       $assignment_img = '';
                       if($assig_data->assignment_image){
                        $assignment_img =  config('ramdoot.appurl')."/upload/assignment_image/".$assig_data->assignment_image;
                        }
                        $is_submited=0;
                        $assignment_submission_created_at='';
                        $assignment_submission_updated_at='';

                        $get_assignment_question = AssignmentQuestion::with('question')->where(['assignment_id' => $assig_data->id])->get();
                        $assignment_question=[];$is_submit=0;$media_question=[];
                        if(count($get_assignment_question) > 0){
                            foreach ($get_assignment_question as $key_assignment => $value_assignment) {

                                $check_submit_question = AssignmentSubmission::where(['user_id' => $request->student_id,'assignment_id' => $value->assignment_id,'question_id' => $value_assignment->question_id])->first();
                                $is_submited = 0;
                                if($check_submit_question){
                                    $is_submited = 1;
                                }

                                $media_question_check = AssignmentSubmission::where(['assignment_id' => $assig_data->id,'user_id' => $request->student_id,'question_id' => $value_assignment->question_id])->first();
                                
                                if($media_question_check){
                                   
                                    // if($media_question_check->question_id != 0){
                                    //     $media_question = AssignmentSubmission::with('assignment_document')->where(['id' => $media_question_check->id])->get();
                                    // }

                                  //  $media_question_check = AssignmentSubmission::where(['assignment_id' => $assig_data->id,'user_id' => $request->student_id])->first();
                                //dd($media_question_check);
                                    
                                  //  if($media_question_check){

                                        $is_submit = $media_question_check->is_submit;
                                        $assignment_submission_created_at = $media_question_check->created_at;
                                        $assignment_submission_updated_at = $media_question_check->updated_at;

                                        if($media_question_check->question_id != 0){

                                            $media_question_details = AssignmentSubmission::where(['id' => $media_question_check->id,'question_id' =>$media_question_check->question_id])->get();
                                        }
                                        else{
                                            $media_question_details = AssignmentSubmission::where(['id' => $media_question_check->id])->get();
                                        }
                                       
                                        // if($media_question_check->question_id != 0){
                                        //     $media_question_details = AssignmentSubmission::where(['id' => $media_question_check->id])->get();

                                            $media_question=[];
                                            foreach ($media_question_details as $key_media_question => $value_media_question) {

                                                $get_doc = AssignmentDocument::where(['assignment_submission_id' => $value_media_question->id])->get();
                                                $assignment_documents_question=[];
                                                foreach ($get_doc as $key_get_doc => $value_get_doc) {
                                                    $doc_path='';
                                                    if($value_get_doc->document){
                                                        $doc_path =   config('ramdoot.appurl')."/upload/assignment_document/".$value_get_doc->document;
                                                    }

                                                    $assignment_documents_question[] = ['id' => $value_get_doc->id,'assignment_submission_id' => $value_get_doc->assignment_submission_id,'document' => $doc_path,'created_at' => $value_get_doc->created_at,'updated_at' => $value_get_doc->updated_at];
                                                }

                                                $media_question[] = ['id' => $value_media_question->id,'user_id' => $value_media_question->user_id,'assignment_id' => $value_media_question->assignment_id,'question_id' => $value_media_question->question_id,'answer' => $value_media_question->answer,'teacher_id' => $value_media_question->teacher_id,'marks' => $value_media_question->marks,'comment' => $value_media_question->comment,'emoji' => $value_media_question->emoji,'is_submit' => $value_media_question->is_submit,'created_at' => $value_media_question->created_at,'updated_at' => $value_media_question->updated_at,'assignment_documents' => $assignment_documents_question];

                                               // $media_question[] = ['id' => $value_media_question->id,'user_id' => $value_media_question->user_id,'assignment_id' => $value_media_question->assignment_id,'question_id' => $value_media_question->question_id,'answer' => $value_media_question->answer,'teacher_id' => $value_media_question->teacher_id,'marks' => $value_media_question->marks,'comment' => $value_media_question->comment,'emoji' => $value_media_question->emoji,'created_at' => $value_media_question->created_at,'updated_at' => $value_media_question->updated_at,'assignment_documents' => $assignment_documents_question];
                                            }
                                       // }
                                  //  }

                                }
                                else{
                                    $media_question=[];
                                }




                                // if($assig_data->question_id != 0){
                                //     $media_question = AssignmentSubmission::with('assignment_document')->where(['assignment_id' => $assig_data->id,'question_id' => 
                                //         $value_assignment->question_id])->get();
                                           
                                // }

                             

                                $assignment_question[] = ['id' => $value_assignment->id,'assignment_id' => $value_assignment->assignment_id,'semester_id' => $value_assignment->semester_id,'unit_id' => $value_assignment->unit_id,'question_id' => $value_assignment->question_id,'question_type' => $value_assignment->question_type,'marks' => $value_assignment->marks,'created_at' => $value_assignment->created_at,'updated_at' => $value_assignment->updated_at,'is_submited' => $is_submited,'media' => $media_question,'question' => $value_assignment->question];
                            }    
                        }

                        $get_dates = AssignmentStudent::where(['student_id' => $request->student_id,'assignment_id' => $assig_data->id])->first();
                                
                        $assignment_assign_date='';$assignment_submission_date='';$assignment_review_date='';
                        if($get_dates){

                            $assignment_assign_date=$get_dates->created_at;
                            $assignment_submission_date=isset($get_dates->student_submission_date) ? $get_dates->student_submission_date:'';
                            $assignment_review_date=isset($get_dates->teacher_submission_date) ? $get_dates->teacher_submission_date:'';
                        }
                        

                        $assignment[] = ['id' => $assig_data->id,'user_id' => $assig_data->user_id,'class_id' => $assig_data->class_id,'assignment_type' => $assig_data->assignment_type,'subject_id' => $assig_data->subject_id,'mode' => $assig_data->mode,'title' => $assig_data->title,'assignment_details' => $assig_data->assignment_details,'assignment_date' => $assig_data->assignment_date,'assignment_time' => $assig_data->assignment_time,'due_date' => $assig_data->due_date,'due_time' => $assig_data->due_time,'total_questions' => $assig_data->total_questions,'total_marks' => $assig_data->total_marks,'assignment_image' => $assig_data->assignment_image,'assignment_option' => $assig_data->assignment_option,'water_mark' => $assig_data->water_mark,'footer' => $assig_data->footer,'instruction' => $assig_data->instruction,'font_size' => $assig_data->font_size,'marks_on' => $assig_data->marks_on,'created_at' => $assig_data->created_at,'updated_at' => $assig_data->updated_at,'total_submission' => $total_submission,'total_review' => $total_reviews,'total_assignment_sent' => $total_assignment_sent,'is_submit' => $is_submit,'assignment_created_at' => $assignment_submission_created_at,'assignment_updated_at' => $assignment_submission_updated_at,'assignment_assign_date' => $assignment_assign_date,'assignment_submission_date' => $assignment_submission_date,'assignment_review_date' => $assignment_review_date,'assignment_image_url' => 
                            $assignment_img,'media' => $media_assignment,'assignment_document' =>  $assignment_document,'assignment_question' => $assignment_question];

                        // $assignment[] = Assignment::with('assignment_question','assignment_question.question')->where('id',$assig_data->id)->select('*',DB::raw("CONCAT('$total_submission') AS total_submission"),DB::raw("CONCAT('$assignment_img') AS assignment_image_url"))->first(); 
                   } 
                   
                }
            }
            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $assignment,
            ]);
        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "Student not found.",
                "data" => [],
            ]);
        }

    }


    public function teacherAssignmentComment(Request $request){

        $rules = array(
            'student_id' => 'required',
            'assignment_id' => 'required',
            'teacher_id' => 'required',
            'question_id' => 'required',
            'marks' => 'required'
        );
        $messages = array(
            'student_id' => 'Please enter student id.',
            'assignment_id' => 'Please enter assignment id.',
            'teacher_id' => 'Please enter teacher id.',
            'question_id' => 'Please enter question id.',
            'marks' => 'Please enter marks.'
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        if($request->question_id != "0"){

            $check_assignment = AssignmentSubmission::where(['user_id' => $request->student_id,'assignment_id' => $request->assignment_id,'question_id' => $request->question_id])->first();

            if($check_assignment){
                $add = AssignmentSubmission::find($check_assignment->id);
                $add->teacher_id = $request->teacher_id;
                $add->question_id = $request->question_id;
                $add->marks = $request->marks;
                $add->comment = $request->comment;
                $add->emoji = $request->emoji;
                $add->save();       

                return response()->json([
                    "code" => 200,
                    "message" => "success"
                ]);
            }
            else{
                return response()->json([
                    "code" => 400,
                    "message" => "Assignment not found.",
                    "data" => [],
                ]);
            }

        
            
        }
        else{
            $check_assignment = AssignmentSubmission::where(['user_id' => $request->student_id,'assignment_id' => $request->assignment_id,'question_id' => 0])->first();

            if($check_assignment){

                $add = AssignmentSubmission::find($check_assignment->id);
                $add->teacher_id = $request->teacher_id;
                $add->question_id = 0;
                $add->marks = $request->marks;
                $add->comment = $request->comment;
                $add->emoji = $request->emoji;
                $add->save();

                return response()->json([
                    "code" => 200,
                    "message" => "success"
                ]);
            }
            else{
                return response()->json([
                    "code" => 400,
                    "message" => "Assignment not found.",
                    "data" => [],
                ]);
            }
            
            
        }


    }

    
    public function teacherAssignmentGenerate(Request $request){

        $rules = array(
            'class_id' => 'required',
            'assignment_type' => 'required',
        );
        $messages = array(
            'class_id' => 'Please enter class id.',
            'assignment_type' => 'Please enter assignment id.',
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $new_name=null;
        if($request->has('assignment_image'))
        {
        
            $image = $request->file('assignment_image');
            $url = public_path('upload/assignment_image/');
            $originalPath = $url;
            $name = time() . mt_rand(10000, 99999);
            $new_name = $name . '.' . $image->getClientOriginalExtension();
            $image->move($originalPath, $new_name);           
        }

        $add = new TeacherAssignment;
        $add->user_id = $request->user_id;
        $add->class_id = $request->class_id;
        $add->assignment_type = $request->assignment_type;
        $add->subject_id = $request->subject_id;
        $add->mode = $request->mode;
        $add->title = $request->title;
        $add->assignment_details = $request->assignment_details;
        $add->assignment_date = $request->assignment_date;
        $add->assignment_time = $request->assignment_time;
        $add->due_date = $request->due_date;
        $add->due_time = $request->due_time;
        $add->assignment_option = $request->assignment_option;
        $add->assignment_image = $new_name;
        $add->unit_id = $request->unit_id;
        $add->semester_id = $request->semester_id;
        $add->save();
        
        if($request->has('documents')){
            for ($doc=0; $doc < count($request->documents); $doc++) {

                $image = $request->documents[$doc];
                $url = public_path('upload/assignment_document/');
                $originalPath = $url;
                $name = time() . mt_rand(10000, 99999);
                $new_name = $name . '.' . $image->getClientOriginalExtension();
                $image->move($originalPath, $new_name);

                $add_doc = new TeacherAssignmentDocument;
                $add_doc->teacher_assignment_id = $add->id;
                $add_doc->document = $new_name;
                $add_doc->save();
                           
            }    
        }
        
        return response()->json([
            "code" => 200,
            "message" => "success",
        ]);

    }


    public function teacherAssignmentList(Request $request){

        $rules = array(
            'class_id' => 'required',
            'user_id' => 'required',
        );
        $messages = array(
            'class_id' => 'Please enter class id.',
            'user_id' => 'Please enter Student id.',
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $check_class = Classroom::where(['id' => $request->class_id,'status' => 'Active'])->first();

        if($check_class){

            if($request->user_id == "0"){

                $get_assignment_list = TeacherAssignment::where(['class_id' => $check_class->id])->get();

                $assignment=[];
                foreach ($get_assignment_list as $key => $value) {

                    $assignment_img = '';
                    if($value->assignment_image){
                        $assignment_img =  config('ramdoot.appurl')."/upload/assignment_image/".$value->assignment_image;
                    }
                        
                    $get_document = TeacherAssignmentDocument::where(['teacher_assignment_id' => $value->id])->get();
                    $documents=[];
                    foreach ($get_document as $key_sub => $value_sub) {
                        $doc_path='';
                        if($value_sub->document){
                            $doc_path =   config('ramdoot.appurl')."/upload/assignment_document/".$value_sub->document;
                        }
                        $documents[] = ['id' => $value_sub->id,'teacher_assignment_id' => $value_sub->teacher_assignment_id,'document' => $doc_path,'created_at' => $value_sub->created_at,'updated_at' => $value_sub->updated_at,];         
                    }

                    $assignment[] = ['id' => $value->id,'user_id' => $value->user_id,'class_id' => $value->class_id,'assignment_type' => $value->assignment_type,'subject_id' => $value->subject_id,'semester_id' => $value->semester_id,'unit_id' => $value->unit_id,'mode' => $value->mode,'title' => $value->title,'assignment_details' => $value->assignment_details,'assignment_date' => $value->assignment_date,'assignment_time' => $value->assignment_time,'due_date' => $value->due_date,'due_time' => $value->due_time,'assignment_image' => $assignment_img,'assignment_option' => $value->assignment_option,'created_at' => $value->created_at,'updated_at' => $value->updated_at,'assignment_document' => $documents];    
                }

                return response()->json([
                    "code" => 200,
                    "message" => "success",
                    "data" => $assignment,
                ]);

            }
            else{
                //dd('df');
                $check_student = User::where(['id' => $request->user_id])->first();
                    
                if($check_student){

                    $get_student_assignment = AssignmentStudent::where(['student_id' => $check_student->id])->get();

                    $assignment=[];
                    if(count($get_student_assignment) > 0){
                        foreach ($get_student_assignment as $key => $value) {
                            //dd($value->assignment_id,$value->student_id,$request->class_id);
                            $assig_data = TeacherAssignment::where(['id' => $value->assignment_id,'class_id' => $request->class_id])->first();
                           //dd($assig_data);
                           if($assig_data){

                               // $get_assignment_list = TeacherAssignment::where(['id' => $assig_data->id])->get();


                              //  foreach ($get_assignment_list as $key => $value) {
                                    $assignment_img = '';
                                    if($assig_data->assignment_image){
                                        $assignment_img =  config('ramdoot.appurl')."/upload/assignment_image/".$assig_data->assignment_image;
                                    }
                                        
                                    $get_document = TeacherAssignmentDocument::where(['teacher_assignment_id' => $assig_data->id])->get();
                                    $documents=[];
                                    foreach ($get_document as $key_sub => $value_sub) {
                                        $doc_path='';
                                        if($value_sub->document){
                                            $doc_path =   config('ramdoot.appurl')."/upload/assignment_document/".$value_sub->document;
                                        }
                                        $documents[] = ['id' => $value_sub->id,'teacher_assignment_id' => $value_sub->teacher_assignment_id,'document' => $doc_path,'created_at' => $value_sub->created_at,'updated_at' => $value_sub->updated_at,];         
                                    }

                                    $assignment[] = ['id' => $assig_data->id,'user_id' => $assig_data->user_id,'class_id' => $assig_data->class_id,'assignment_type' => $assig_data->assignment_type,'subject_id' => $assig_data->subject_id,'semester_id' => $assig_data->semester_id,'unit_id' => $assig_data->unit_id,'mode' => $assig_data->mode,'title' => $assig_data->title,'assignment_details' => $assig_data->assignment_details,'assignment_date' => $assig_data->assignment_date,'assignment_time' => $assig_data->assignment_time,'due_date' => $assig_data->due_date,'due_time' => $assig_data->due_time,'assignment_image' => $assignment_img,'assignment_option' => $assig_data->assignment_option,'created_at' => $assig_data->created_at,'updated_at' => $assig_data->updated_at,'assignment_document' => $documents];    
                              //  }

                                
                           }
                        }

                        if(count($assignment) > 0){
                            return response()->json([
                                "code" => 200,
                                "message" => "success",
                                "data" => $assignment,
                            ]);    
                        }else{
                           return response()->json([
                                "code" => 400,
                                "message" => "Assignment not found.",
                                "data" => [],
                            ]); 
                        }
                    }

                }
                else{
                    return response()->json([
                        "code" => 400,
                        "message" => "Student not found.",
                        "data" => [],
                    ]);
                }

                $get_assignment_list = TeacherAssignment::where(['class_id' => $request->$check_class])->get();

            }

        }
        else{

            return response()->json([
                "code" => 400,
                "message" => "Class not found.",
                "data" => [],
            ]);
        }

    }

    public function delete_question(Request $request)
    {
        $rules = array(
            'virtual_assignment_question_id' => 'required'    
        );
        $messages = array(
            'virtual_assignment_question_id' => 'Please enter virtual assignment question id.'
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $check_question = VirtualAssignmentQuestions::where(['id' => $request->virtual_assignment_question_id])->first();

        if($check_question){
            VirtualAssignmentQuestions::where(['id' => $check_question->id])->delete(); 
            return response()->json([
                "code" => 200,
                "message" => "success"
            ]);   
        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "Question not found.",
                "data" => [],
            ]);
        }

        
    }


    public function shuffle_question(Request $request)
    {
        $rules = array(
            'virtual_assignment_question_id' => 'required'    
        );
        $messages = array(
            'virtual_assignment_question_id' => 'Please enter virtual assignment question id.'
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $check_question = VirtualAssignmentQuestions::where(['id' => $request->virtual_assignment_question_id])->first();

        if($check_question){

            $get_exits_question = VirtualAssignmentQuestions::where(['class_id' => $check_question->class_id])->get();
            $question_arr=[];
            foreach ($get_exits_question as $key_old => $value_old) {
                $question_arr[] = $value_old->question_id;
            }
            
           // dd($check_question);

            $solution_questions = Solution::where('id',$check_question->question_id)->first();

            if($solution_questions){
               // dd($questions_get);

                $questions_get = Solution::where(['board_id' => $solution_questions->board_id,'medium_id' => $solution_questions->medium_id,"standard_id" => $solution_questions->standard_id,"semester_id" => $solution_questions->semester_id,"subject_id" => $solution_questions->subject_id,"unit_id" => $solution_questions->unit_id,'question_type' => $solution_questions->question_type])->whereNotIn('id', $question_arr)->inRandomOrder()->limit(1)->get();

                
                if(count($questions_get) > 0){
                    foreach ($questions_get as $key_get => $value_get) {
                        
                        VirtualAssignmentQuestions::where(['id' => $check_question->id])->update(['question_id' => $value_get->id]);

                        return response()->json([
                            "code" => 200,
                            "message" => "success",
                            "data" => $questions_get,
                        ]);
                    }     
                }
                else{

                    return response()->json([
                        "code" => 400,
                        "message" => "Shuffle Question not found.",
                        "data" => [],
                    ]);
                }
                  
            }
            else{

                return response()->json([
                    "code" => 400,
                    "message" => "Question not found.",
                    "data" => [],
                ]);

            }

        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "Virtual Assignment Question not found.",
                "data" => [],
            ]);
        } 
    }


    public function edit_question(Request $request)
    {
        $rules = array(
            'virtual_assignment_question_id' => 'required'    
        );
        $messages = array(
            'virtual_assignment_question_id' => 'Please enter virtual assignment question id.'
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $check_question = VirtualAssignmentQuestions::where(['id' => $request->virtual_assignment_question_id])->first();

        if($check_question){
            VirtualAssignmentQuestions::where(['id' => $check_question->id])->update(['question_id' => $request->new_question_id]);   
            return response()->json([
                "code" => 200,
                "message" => "success"
            ]);   
        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "Question not found.",
                "data" => [],
            ]);
        }
    }


    public function classgroupjoin(Request $request)
    {
        $rules = array(
            'user_id' => 'required',
            'passcode' => 'required',
            'group_id' => 'required'
        );
        $messages = array(
            'user_id.required' => 'Please enter user id.',
            'passcode.required' => 'Please enter passcode.',
            'group_id.required' => 'Please enter group id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $usercheck = User::where(['id' => $request->user_id])->first();

        if ($usercheck) {
            $classGroup = DB::table('classroom_groups')->where(['id' => $request->group_id])->first();
            if($classGroup->passcode == $request->passcode){
                $classroom_ids = explode(",",$classGroup->class_ids);
                foreach($classroom_ids as $classroom_id){
                    $classroom_details = Classroom::where('id',$classroom_id)->first();
                    if($classroom_details){
                        $class_id = $classroom_details->id;
                        //dd($class_id,$request->user_id);
                        $check_classstudent = ClassStudent::where(['class_id' => $class_id,'user_id' => $request->user_id])->first();
                        //dd($check_classstudent);
                        if($check_classstudent){
                            if($check_classstudent->status == "reject"){
                                $classStudent = ClassStudent::find($check_classstudent->id);
                                $classStudent->status = 'aprove';
                                $classStudent->save();
                            }
                        }
                        else{
                            $classStudent = new ClassStudent();
                            $classStudent->class_id = $class_id;
                            $classStudent->user_id = $request->user_id;
                            $classStudent->status = 'aprove';
                            $classStudent->save();
                        }
                    }
                }
            }else {
                return response()->json([
                    "code" => 400,
                    "message" => "Passcode not match.",
                    "data" => [],
                ]);
            }
            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => []
            ]);
        } else {
            return response()->json([
                "code" => 400,
                "message" => "User not found.",
                "data" => [],
            ]);
        }
    }


    public function classDetail(Request $request){
        
        $rules = array(
            'classroom_id' => 'required'
        );
        $messages = array(
            'classroom_id.required' => 'Please enter classroom id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $check_class = Classroom::where('classroom_id',$request->classroom_id)->first();

        if($check_class){

           $data =  ['id' => $check_class->id,'user_id' => $check_class->user_id,'board_id' => $check_class->board_id,'board' => 
            isset($check_class->board->sub_title) ? $check_class->board->sub_title:'','medium_id' => $check_class->medium_id,
            'medium' => isset($check_class->medium->sub_title) ? $check_class->medium->sub_title:'','standard_id' => 
            $check_class->standard_id,'standard' => isset($check_class->standard->standard) ? $check_class->standard->standard:'',
            'subject_id' => $check_class->subject_id,
            'subject' => isset($check_class->subject->sub_title) ? $check_class->subject->sub_title:'',
            'semester_id' => $check_class->semester_id,
            'semester' => isset($check_class->semester->semester) ? $check_class->semester->semester:'',
            'division' => $check_class->division,'strenth' => $check_class->strenth,
            'classroom_id' => $check_class->classroom_id,'type'=> $check_class->type,'status' => $check_class->status];

            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $data,
            ]);   
        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "Classroom not found."
            ]);   
        }
    }

    public function createGroup(Request $request){

        $rules = array(
            'user_id' => 'required',
            'standard_id' => 'required',
            'group_name' => 'required',
            'passcode' => 'required',
            'class_id' => 'required',
        );
        $messages = array(
            'user_id.required' => 'Please enter user id.',
            'standard_id' => 'Please enter standard id.',
            'group_name' => 'Please enter group name.',
            'passcode' => 'Please enter passcode.',
            'class_id' => 'Please enter class id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkuser = User::where(['id' => $request->user_id])->first();
        $chkstandard = Standard::where(['id' => $request->standard_id,'status' => 'Active'])->first();

        if (empty($chkuser)) {
            return response()->json([
                "code" => 400,
                "message" => "User not found.",
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
        else
        {
            $add =  new ClassroomGroup;
            $add->user_id = $request->user_id;
            $add->standard_id = $request->standard_id;
            $add->group_name = $request->group_name;
            $add->passcode = $request->passcode;
            $add->class_ids  = $request->class_id;
            $add->status = "Active";
            $add->save();

            return response()->json([
                "code" => 200,
                "message" => "success",
            ]);
        }
    }

    public function editGroup(Request $request){

        $rules = array(
            'group_id' => 'required',
            'user_id' => 'required',
            'standard_id' => 'required',
            'group_name' => 'required',
            'passcode' => 'required',
            'class_id' => 'required',
        );
        $messages = array(
            'group_id.required' => 'Please enter group id.',
            'user_id.required' => 'Please enter user id.',
            'standard_id' => 'Please enter standard id.',
            'group_name' => 'Please enter group name.',
            'passcode' => 'Please enter passcode.',
            'class_id' => 'Please enter class id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkuser = User::where(['id' => $request->user_id])->first();
        $chkstandard = Standard::where(['id' => $request->standard_id,'status' => 'Active'])->first();
        $chkgroup = ClassroomGroup::where(['id' => $request->group_id,'status' => 'Active'])->first();

        if (empty($chkuser)) {
            return response()->json([
                "code" => 400,
                "message" => "User not found.",
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
        elseif (empty($chkgroup)) {
            return response()->json([
                "code" => 400,
                "message" => "Classroom group not found.",
                "data" => [],
            ]);
        }
        else
        {
            $add =  ClassroomGroup::find($request->group_id);
            $add->user_id = $request->user_id;
            $add->standard_id = $request->standard_id;
            $add->group_name = $request->group_name;
            $add->passcode = $request->passcode;
            $add->class_ids  = $request->class_id;
            $add->status = "Active";
            $add->save();

            return response()->json([
                "code" => 200,
                "message" => "success",
            ]);
        }
    }

    public function viewGroup(Request $request){

        $rules = array(
            'user_id' => 'required',
            'standard_id' => 'required'
        );
        $messages = array(
            'user_id.required' => 'Please enter user id.',
            'standard_id' => 'Please enter standard id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        $chkuser = User::where(['id' => $request->user_id])->first();

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        if (empty($chkuser)) {
            return response()->json([
                "code" => 400,
                "message" => "User not found.",
                "data" => [],
            ]);
        }
        else{

            if($request->standard_id != "0"){

                $get_classgroup = ClassroomGroup::where(['user_id' => $request->user_id,'standard_id' => $request->standard_id,'status' => 'Active'])->get();
            }
            else{
                $get_classgroup = ClassroomGroup::where(['user_id' => $request->user_id,'status' => 'Active'])->get();
            }

            $group_data=[];
            foreach ($get_classgroup as $key_group => $value_group) {

                $link = "https://www.ramdootedu.world/view_group/?group_id=".$value_group->id."&passcode=".$value_group->passcode;

                $classids = explode(',', $value_group->class_ids);

                $class_arr=[];
                if(count($classids) > 0){
                    foreach ($classids as $key_class => $value_class) {
                        $get_class = Classroom::where('id',$value_class)->first();

                        $class_arr[] =  ['id' => $get_class->id,'user_id' => $get_class->user_id,'board_id' => $get_class->board_id,'board' => 
                            isset($get_class->board->sub_title) ? $get_class->board->sub_title:'','medium_id' => $get_class->medium_id,
                            'medium' => isset($get_class->medium->sub_title) ? $get_class->medium->sub_title:'','standard_id' => 
                            $get_class->standard_id,'standard' => isset($get_class->standard->standard) ? $get_class->standard->standard:'',
                            'subject_id' => $get_class->subject_id,
                            'subject' => isset($get_class->subject->sub_title) ? $get_class->subject->sub_title:'',
                            'semester_id' => $get_class->semester_id,
                            'semester' => isset($get_class->semester->semester) ? $get_class->semester->semester:'',
                            'division' => $get_class->division,'strenth' => $get_class->strenth,
                            'classroom_id' => $get_class->classroom_id,'type'=> $get_class->type,'status' => $get_class->status];
                    }
                    
                }
                
                $group_data[] = ["id" => $value_group->id,"user_id" => $value_group->user_id,"standard_id" => $value_group->standard_id,"group_name" => $value_group->group_name,"class_ids" => $value_group->class_ids,"passcode" => $value_group->passcode,"status" => $value_group->status,"created_at" => $value_group->created_at,"updated_at" => $value_group->updated_at,'link' => $link,'class' => $class_arr];

            }

            
            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $group_data,
            ]);

        }

    }


    public function editAssignment(Request $request){
        $rules = array(
            'assignment_id' => 'required'
        );
        $messages = array(
            'assignment_id.required' => 'Please enter assignment id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkassignment = Assignment::where(['id' => $request->assignment_id,'status' => 'Active'])->first();

        if($chkassignment){

            $update = Assignment::find($chkassignment->id);
            $update->assignment_date = $request->assignment_date;
            $update->assignment_time = $request->assignment_time;
            $update->due_date = $request->due_date;
            $update->due_time = $request->due_time;
            $update->instruction = isset($request->instruction) ? $request->instruction:null;
            $update->save();

            return response()->json([
                "code" => 200,
                "message" => "success"
            ]);
        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "Assignment not found.",
                "data" => [],
            ]);
        }
    }

    public function deleteAssignment(Request $request){
        $rules = array(
            'assignment_id' => 'required'
        );
        $messages = array(
            'assignment_id.required' => 'Please enter assignment id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkassignment = Assignment::where(['id' => $request->assignment_id,'status' => 'Active'])->first();

        if($chkassignment){

            $update = Assignment::find($chkassignment->id);
            $update->status = "Deleted";
            $update->save();

            return response()->json([
                "code" => 200,
                "message" => "success"
            ]);
        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "Assignment not found.",
                "data" => [],
            ]);
        }
    }

    public function addTimetable(Request $request){

        $rules = array(
            'user_id' => 'required',
            'class_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'day' => 'required'
        );
        $messages = array(
            'user_id.required' => 'Please enter user id.',
            'class_id.required' => 'Please enter class id.',
            'start_time.required' => 'Please enter start time.',
            'end_time.required' => 'Please enter end time.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkuser = User::where(['id' => $request->user_id])->first();
        $chkclass = Classroom::where(['id' => $request->class_id,'status' => 'Active'])->first();

        if (empty($chkuser)) {
            return response()->json([
                "code" => 400,
                "message" => "User not found.",
                "data" => [],
            ]);
        }
        elseif (empty($chkclass)) {
            return response()->json([
                "code" => 400,
                "message" => "Classroom not found.",
                "data" => [],
            ]);
        }
        else
        {
            $add = new TimeTable;
            $add->user_id = $request->user_id;
            $add->class_id = $request->class_id;
            $add->start_time = $request->start_time;
            $add->end_time = $request->end_time;
            $add->day  = $request->day;
            $add->is_show = 1;
            $add->save();

            return response()->json([
                "code" => 200,
                "message" => "success",
            ]);
        }

       // 

    }


    public function editTimetable(Request $request){
        
        $rules = array(
            'timetable_id' => 'required',
            'user_id' => 'required',
            'class_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'day' => 'required'
        );
        $messages = array(
            'timetable_id' => 'required',
            'user_id.required' => 'Please enter user id.',
            'class_id.required' => 'Please enter class id.',
            'start_time.required' => 'Please enter start time.',
            'end_time.required' => 'Please enter end time.',
            'day.required' => 'Please enter day.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkuser = User::where(['id' => $request->user_id])->first();
        $chkclass = Classroom::where(['id' => $request->class_id,'status' => 'Active'])->first();
        $chktimetable = TimeTable::where(['id' => $request->timetable_id])->first(); 

        if (empty($chkuser)) {
            return response()->json([
                "code" => 400,
                "message" => "User not found.",
                "data" => [],
            ]);
        }
        elseif (empty($chkclass)) {
            return response()->json([
                "code" => 400,
                "message" => "Classroom not found.",
                "data" => [],
            ]);
        }
        elseif (empty($chktimetable)) {
            return response()->json([
                "code" => 400,
                "message" => "TimeTable not found.",
                "data" => [],
            ]);
        }
        else
        {
            $update = TimeTable::find($request->timetable_id);
            $update->user_id = $request->user_id;
            $update->class_id = $request->class_id;
            $update->start_time = $request->start_time;
            $update->end_time = $request->end_time;
            $update->day  = $request->day;
            //$update->is_show = $request->is_show;
            $update->save();

            return response()->json([
                "code" => 200,
                "message" => "success",
            ]);
        }

    }


    public function deleteTimetable(Request $request){
        $rules = array(
            'timetable_id' => 'required'
        );
        $messages = array(
            'timetable_id.required' => 'Please enter time table id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chktimetable = TimeTable::where(['id' => $request->timetable_id])->first();

        if($chktimetable) {

            TimeTable::find($request->timetable_id)->delete();
            return response()->json([
                "code" => 200,
                "message" => "success",
            ]);
        }
        else{
            return response()->json([
                "code" => 400,
                "message" => "TimeTable not found."
            ]);
        }

    }

    public function viewTimetable(Request $request){
        
        $rules = array(
            'class_id' => 'required'
        );
        $messages = array(
            'class_id.required' => 'Please enter class id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }   

        $chkclass = Classroom::where(['id' => $request->class_id,'status' => 'Active'])->first();

        if($chkclass){
            $get_timetable = TimeTable::where(['class_id' => $request->class_id])->groupby('day')->get();

            // $week = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];

            $day_arr=[];
            foreach ($get_timetable as $keyday => $valueday) {
                
                $day = date('w', strtotime($valueday->day));
                $day_arr[$valueday->day] = $day;
            }
            asort($day_arr);

            if(count($day_arr) > 0){
                foreach ($day_arr as $key_day => $value_day) {

                    $get_lecture = TimeTable::where(['day' => $key_day,'class_id' => $request->class_id])->select('id','start_time','end_time')->get();

                    $get_array=[];
                    foreach ($get_lecture as $key_time => $value_time) {
                        $get_array[$value_time->id] = $value_time->start_time;
                    }
                    asort($get_array);

                    $get_final_array=[];
                    foreach ($get_array as $key_arr => $value_arr) {
                        $get_final_array[] = TimeTable::where(['id' => $key_arr])->select('id','start_time','end_time')->first();
                    }

                    $get_status = TimeTable::where(['class_id' => $request->class_id,'day' => $key_day])->first();
                    $data[] = ['day' => $key_day,'is_show' => $get_status->is_show,'lecture' => $get_final_array];
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
                    "message" => "TimeTable not found.",
                    "data" => [],
                ]);
            }

            
        }
        else{

            return response()->json([
                "code" => 400,
                "message" => "Classroom not found.",
                "data" => [],
            ]);

        }

    }
    

    public function timetableStatusChange(Request $request){
        $rules = array(
            'user_id' => 'required',
            'class_id' => 'required',
            'day' => 'required',
            'is_show' => 'required',
        );
        $messages = array(
            'user_id.required' => 'Please enter user id.',
            'class_id.required' => 'Please enter class id.',
            'day.required' => 'Please enter day.',
            'is_show.required' => 'Please enter is show status.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }
    


        $chkuser = User::where(['id' => $request->user_id])->first();
        $chkclass = Classroom::where(['id' => $request->class_id,'status' => 'Active'])->first();

        if (empty($chkuser)) {
            return response()->json([
                "code" => 400,
                "message" => "User not found.",
                "data" => [],
            ]);
        }
        elseif (empty($chkclass)) {
            return response()->json([
                "code" => 400,
                "message" => "Classroom not found.",
                "data" => [],
            ]);
        }
        else{

            $get_timetable = TimeTable::where(['class_id' => $request->class_id,'user_id' => $request->user_id,'day' => $request->day])
                            ->update(['is_show' => $request->is_show]);
            
            return response()->json([
                "code" => 200,
                "message" => "success"
            ]);

        }
    }


    public function deleteGroup(Request $request){
        $rules = array(
            'group_id' => 'required',
        );
        $messages = array(
            'group_id.required' => 'Please enter group id.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }


        $get_classgroup = ClassroomGroup::where(['id' => $request->group_id,'status' => 'Active'])->first();

        if($get_classgroup){

            ClassroomGroup::where(['id' => $get_classgroup->id])->update(['status' => 'Deleted']);

            return response()->json([
                "code" => 200,
                "message" => "success"
            ]);
        }
        else{

            return response()->json([
                "code" => 400,
                "message" => "Classroom Group Not Found."
            ]);
        }


    }

    public function addQuestionsSmartCreation(Request $request)
    {

        $rules = array(
            'class_id' => 'required',
            'semester_id' => 'required',
            'unit_id' => 'required',
            'assignment_type' => 'required',
            'question_type' => 'required',
            'question_mark' => 'required',
            'question_count' => 'required',
            'mode' => 'required',
        );
        $messages = array(
            'class_id' => 'Please enter class id.',
            'semester_id' => 'Please enter semester id.',
            'unit_id' => 'Please enter assignment type.',
            'assignment_type' => 'Please enter assignment type.',
            'question_type' => 'Please enter question type.',
            'question_mark' => 'Please enter question mark.',
            'question_count' => 'Please enter question count.',
            'mode' => 'Please enter mode',
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chksemester = Semester::where(['id' => $request->semester_id,'status' => 'Active'])->first();
        $chkunit = Unit::where(['id' => $request->unit_id,'status' => 'Active'])->first();
        $check_class = Classroom::where(['id' => $request->class_id,'status' => 'Active'])->first();

        if(empty($chksemester)){
            return response()->json([
                "code" => 400,
                "message" => "Semester not found.",
                "data" => [],
            ]);
        }
        elseif (empty($chkunit)) {
            return response()->json([
                "code" => 400,
                "message" => "Unit not found.",
                "data" => [],
            ]);
        }
        elseif (empty($check_class)) {
            return response()->json([
                "code" => 400,
                "message" => "Classroom not found.",
                "data" => [],
            ]);
        }
        else{

            $get_exits_question = VirtualAssignmentQuestions::get();
            $question_arr=[];
            foreach ($get_exits_question as $key_old => $value_old) {
                $question_arr[] = $value_old->question_id;
            }

            $get_question_type = explode(',',$request->question_type);
            $get_question_mark = explode(',',$request->question_mark);
            $get_question_count = explode(',',$request->question_count);
            
            for ($i=0; $i < count($get_question_type); $i++) { 

                $get_questions = Solution::where(['semester_id' => $request->semester_id,'unit_id' => $request->unit_id,'question_type' => $get_question_type[$i]])->whereNotIn('id', $question_arr)->inRandomOrder()->limit($get_question_count[$i])->get();

                if(count($get_questions) > 0){

                    foreach ($get_questions as $key_questions => $value_questions) {
                        
                        $add = new VirtualAssignmentQuestions;
                        $add->class_id = $request->class_id;
                        $add->assignment_type = $request->assignment_type;
                        $add->question_id = $value_questions->id;
                        $add->question_type = $get_question_type[$i];
                        $add->is_mcq = 0;
                        $add->mode = $request->mode;
                        $add->marks = $get_question_mark[$i];
                        $add->save();
                    }
                        
                }
                

            }

            return response()->json([
                "code" => 200,
                "message" => "success",
            ]);            

        }
    }


    public function addExternalQuestion(Request $request)
    {
        $rules = array(
            'board_id' => 'required',
            'medium_id' => 'required',
            'standard_id' => 'required',
            'semester_id' => 'required',
            'subject_id' => 'required',
            'unit_id' => 'required',
            'user_id' => 'required'
        );
        $messages = array(
            'board_id' => 'Please enter board id.',
            'medium_id' => 'Please enter medium id',
            'standard_id' => 'Please enter standard id.',
            'semester_id' => 'Please enter semester id.',
            'subject_id' => 'Please enter subject id.',
            'unit_id' => 'Please enter unit id.',
            'user_id' => 'Please enter user id.'
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
        $chkunit = Unit::where(['id' => $request->unit_id,'status' => 'Active'])->first();
        //$chksemester = Semester::where(['id' => $request->semester_id,'status' => 'Active'])->first();
        //$chkunit = Unit::where(['id' => $request->unit_id,'status' => 'Active'])->first();
        //$check_class = Classroom::where(['id' => $request->class_id,'status' => 'Active'])->first();

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
        elseif (empty($chksemester)) {
            return response()->json([
                "code" => 400,
                "message" => "Semester not found.",
                "data" => [],
            ]);
        }
        elseif (empty($chkunit)) {
            return response()->json([
                "code" => 400,
                "message" => "Unit not found.",
                "data" => [],
            ]);
        }
        else{

            $question_img=null;
            if($request->has('question_image'))
            {
                $questionimage = $request->file('question_image');
                $url = public_path('upload/external_question/');
                $originalPath = $url;
                $name = time() . mt_rand(10000, 99999);
                $question_img = $name . '.' . $questionimage->getClientOriginalExtension();
                $questionimage->move($originalPath, $question_img);           
            }

            $option_1_img=null;
            if($request->has('option_1_image'))
            {
                $option1_image = $request->file('option_1_image');
                $url = public_path('upload/external_question/');
                $originalPath = $url;
                $name = time() . mt_rand(10000, 99999);
                $option_1_img = $name . '.' . $option1_image->getClientOriginalExtension();
                $option1_image->move($originalPath, $option_1_img);           
            }

            $option_2_img=null;
            if($request->has('option_2_image'))
            {
                $option2_image = $request->file('option_2_image');
                $url = public_path('upload/external_question/');
                $originalPath = $url;
                $name = time() . mt_rand(10000, 99999);
                $option_2_img = $name . '.' . $option2_image->getClientOriginalExtension();
                $option2_image->move($originalPath, $option_2_img);           
            }

            $option_3_img=null;
            if($request->has('option_3_image'))
            {
                $option3_image = $request->file('option_3_image');
                $url = public_path('upload/external_question/');
                $originalPath = $url;
                $name = time() . mt_rand(10000, 99999);
                $option_3_img = $name . '.' . $option3_image->getClientOriginalExtension();
                $option3_image->move($originalPath, $option_3_img);           
            }

            $option_4_img=null;
            if($request->has('option_4_image'))
            {
                $option4_image = $request->file('option_4_image');
                $url = public_path('upload/external_question/');
                $originalPath = $url;
                $name = time() . mt_rand(10000, 99999);
                $option_4_img = $name . '.' . $option4_image->getClientOriginalExtension();
                $option4_image->move($originalPath, $option_4_img);           
            }

            $add = new ExternalQuestion;
            $add->board_id = $request->board_id;
            $add->medium_id = $request->medium_id;
            $add->standard_id = $request->standard_id;
            $add->subject_id = $request->subject_id;
            $add->semester_id = $request->semester_id;
            $add->unit_id = $request->unit_id;
            $add->user_id = $request->user_id;
            $add->question = isset($request->question) ? $request->question:null;
            $add->question_image = $question_img;
            $add->option_1 = isset($request->option_1) ? $request->option_1:null;
            $add->option_1_image = $option_1_img;
            $add->option_2 = isset($request->option_2) ? $request->option_2:null;
            $add->option_2_image = $option_2_img;
            $add->option_3 = isset($request->option_3) ? $request->option_3:null;
            $add->option_3_image = $option_3_img;
            $add->option_4 = isset($request->option_4) ? $request->option_4:null;
            $add->option_4_image = $option_4_img;
            $add->level = $request->level;
            $add->save();

            return response()->json([
                "code" => 200,
                "message" => "success",
            ]);            

        }

        
        



    }

    public function getLecture(Request $request){

        $rules = array(
            'day' => 'required',
            'class_id' => 'required'
        );
        $messages = array(
            'day' => 'Please enter day.',
            'class_id' => 'Please enter class id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $check_class = Classroom::where(['id' => $request->class_id,'status' => 'Active'])->first();

        if(empty($check_class)){
            return response()->json([
                "code" => 400,
                "message" => "Classroom not found.",
                "data" => [],
            ]);   
        }
        else{
            $lectures = TimeTable::where('day', $request->day)->where(['class_id' => $request->class_id])->select('id', 'start_time', 'end_time')->get();

            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $lectures,
            ]);
        }

                
    }


    public function addAttendance(Request $request){

        $rules = array(
            'class_id' => 'required',
            'timetable_id' => 'required',
            'date' => 'required',
            'student_ids' => 'required'
        );
        $messages = array(
            'class_id' => 'Please enter day.',
            'timetable_id' => 'Please enter class id.',
            'date' => 'Please enter date.',
            'student_ids' => 'Please enter student ids.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $check_class = Classroom::where(['id' => $request->class_id,'status' => 'Active'])->first();
            
        if(empty($check_class)){
            return response()->json([
                "code" => 400,
                "message" => "Classroom not found.",
                "data" => [],
            ]);   
        }
        else{
            
            $createdData = Attendance::create([
                'class_id' => $request->class_id,
                'timetable_id' => $request->timetable_id,
                'description' => $request->description,
                'date' => $request->date
            ]);

            $student_ids = explode(',',$request->student_ids);

            foreach (array_unique($student_ids) as $student_id) {
                AttendanceStudent::create([
                    'attendance_id' => $createdData->id,
                    'student_id' => $student_id,
                    'is_present' => $request->presented_ids ? in_array($student_id, $request->presented_ids) :  false
                ]);
            }

            return response()->json([
                "code" => 200,
                "message" => "success"
            ]);
        }


    }

    public function editAttendance(Request $request){

        $rules = array(
            'attendance_id' => 'required',
            'student_ids' => 'required'
        );
        $messages = array(
            'attendance_id' => 'Please enter attendance id.',
            'student_ids' => 'Please enter student id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        if ($request->description) {
            Attendance::where('id', $request->attendance_id)->update(['description' => isset($request->description) ? $request->description:'']);
        }

        $student_ids = explode(',',$request->student_ids);
        foreach ($student_ids as $ids) {
            AttendanceStudent::where(['student_id' => $ids,'attendance_id'=>$request->attendance_id])
            ->update([
                'is_present' => $request->presented_ids ? in_array($ids, $request->presented_ids) : false,
            ]);
        }

        return response()->json([
            "code" => 200,
            "message" => "success"
        ]);
    }
    //ClassroomGroup

}

