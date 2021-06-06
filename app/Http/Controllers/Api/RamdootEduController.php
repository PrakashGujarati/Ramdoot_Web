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
                        'user_id' => $value_class->user_id,'board_id' => $value_class->board_id,'board' => 
                        isset($value_class->board->sub_title) ? $value_class->board->sub_title:'','medium_id' => $value_class->medium_id,
                        'medium' => isset($value_class->medium->sub_title) ? $value_class->medium->sub_title:'','standard_id' => $value_class->standard_id,'standard' => isset($value_class->standard->standard) ? $value_class->standard->standard:'','subject_id' => $value_class->subject_id,'subject' => 
                        isset($value_class->subject->sub_title) ? $value_class->subject->sub_title:'',
                        'semester_id' => $value_class->semester_id,'semester' => 
                        isset($value_class->semester->semester) ? $value_class->semester->semester:'','division' => $value_class->division,'strenth' => $value_class->strenth,'classroom_id' => $value_class->classroom_id,'type'=> $value_class->type,'status' => $value_class->status];
                }

        	}
        	elseif ($getrole->slug == "Student") {
        		$classroom_details = ClassStudent::where(['user_id' => $request->user_id])->where('status','!=','reject')->get();
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
                        'user_id' => $classdetails->user_id,'board_id' => $classdetails->board_id,'board' => 
                        isset($classdetails->board->sub_title) ? $classdetails->board->sub_title:'','medium_id' => $classdetails->medium_id,
                        'medium' => isset($classdetails->medium->sub_title) ? $classdetails->medium->sub_title:'','standard_id' => $classdetails->standard_id,'standard' => isset($classdetails->standard->standard) ? $classdetails->standard->standard:'','subject_id' => $classdetails->subject_id,'subject' => $classdetails->subject->sub_title,'semester_id' => $classdetails->semester_id,'semester' => 
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


            $check_assignment = Assignment::where(['id' => $request->assignment_id])->first();

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
        );
        $messages = array(
            'semester_id' => 'Please enter semester id.',
            'unit_id' => 'Please enter unit id.'
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chksemester = Semester::where(['id' => $request->semester_id,'status' => 'Active'])->first();
        $chkunit = Unit::where(['id' => $request->unit_id,'status' => 'Active'])->first();

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
        else{
            $get_unit = Solution::where(['semester_id' => $request->semester_id,'unit_id' => $request->unit_id])->groupby('question_type')->get();
            
            $get_question_type=[];
            foreach ($get_unit as $key => $value) {
                $getquestion_details = QuestionType::select('id','question_type')->where(['id' => $value->question_type])->first();
                $get_question_type[] = $getquestion_details;
            }
            $mcqdetails = ['id' => 0,'question_type' => "MCQ"];
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
        );
        $messages = array(
            'unit_id' => 'Please enter unit id.',
            'category_id' => 'Please enter category_id.',
        );
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkunit = Unit::where(['id' => $request->unit_id,'status' => 'Active'])->first();

        if($request->category_id != 0){
            $chkquestiontype = QuestionType::where(['id' => $request->category_id,'status' => 'Active'])->first();    
        }
        

        if(empty($chkunit)){
            return response()->json([
                "code" => 400,
                "message" => "Unit not found.",
                "data" => [],
            ]);
        }
        else{

            if($request->category_id != 0){

                if(empty($chkquestiontype)){
                    return response()->json([
                        "code" => 400,
                        "message" => "Category not found.",
                        "data" => [],
                    ]);    
                }
                else{
                    $get_question = Solution::where(['unit_id' => $request->unit_id,'question_type' => $request->category_id])->get();
                    return response()->json([
                        "code" => 200,
                        "message" => "success",
                        "data" => $get_question,
                    ]);
                }
            }
            else{
                $get_question = Question::where(['unit_id' => $request->unit_id])->get();
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

        $get_question_details = VirtualAssignmentQuestions::with('questionType')->where(['class_id' => $request->class_id,'assignment_type' => $request->assignment_type])->groupby('marks')->get();

        if(count($get_question_details) > 0){
            $counter_array=[];
            foreach ($get_question_details as $key => $value) {
                if($value->question_type != 0 || $value->is_mcq == 0){
                     $vquestions = VirtualAssignmentQuestions::where(['class_id' => $value->class_id,'marks' => $value->marks,'assignment_type' => $value->assignment_type])->pluck('question_id')->toArray();     
                     $questions = Solution::whereIn('id',$vquestions)->get();
                } 
                else{
                    $vmquestions = VirtualAssignmentQuestions::with('question')->where(['class_id' => $value->class_id,'marks' => $value->marks,'assignment_type' => $value->assignment_type])->pluck('question_id')->toArray();
                    $questions = Solution::whereIn('id',$vmquestions)->get();
                }                                
                $question_array[] = ['id' => $value->id,'class_id' => $value->class_id,'mode' => $value->mode,'assignment_type' => $value->assignment_type,'question_type' => $value->questionType,'is_mcq' => $value->is_mcq,'marks' => $value->marks,'question_solution' => $questions]; //,'question_type_id' => $value->questionType->id,'question_type' => $value->questionType->question_type
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
                "message" => "count not found.",
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

        VirtualAssignmentQuestions::where(['class_id' => $request->class_id])->delete();
        
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

        $check_class = Classroom::where(['id' => $request->class_id])->first();

        if($check_class){

            if($request->student_id != "0"){

                $check_student = User::where(['id' => $request->student_id])->first();
                
                if($check_student){

                    $get_student_assignment = AssignmentStudent::where(['student_id' => $request->student_id])->get();
                   // $assignment_details = Assignment::with('assignment_question')->where(['user_id' => ])->get();
                    $assignment=[];
                    if(count($get_student_assignment) > 0){
                        foreach ($get_student_assignment as $key => $value) {

                            $assig_data = Assignment::where(['id' => $value->assignment_id,'class_id' => $request->class_id])->first();
                           
                           if($assig_data){

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
                               $assignment_img = '';
                               if($assig_data->assignment_image){
                                $assignment_img =  config('ramdoot.appurl')."/upload/assignment_image/".$assig_data->assignment_image;
                                }
                                $is_submited=0;

                                $get_assignment_question = AssignmentQuestion::with('question')->where(['assignment_id' => $assig_data->id])->get();
                                $assignment_question=[];$is_submit=0;
                                if(count($get_assignment_question) > 0){
                                    foreach ($get_assignment_question as $key_assignment => $value_assignment) {

                                        $check_submit_question = AssignmentSubmission::where(['user_id' => $request->student_id,'assignment_id' => $value->assignment_id,'question_id' => $value_assignment->question_id])->first();
                                        $is_submited = 0;
                                        if($check_submit_question){
                                            $is_submited = 1;
                                        }


                                        $media_question_check = AssignmentSubmission::where(['assignment_id' => $assig_data->id,'user_id' => $request->student_id,'question_id' => $value_assignment->question_id])->first();
                                        $media_question=[];
                                        if($media_question_check){
                                           
                                            if($media_question_check->question_id != 0){
                                                $media_question = AssignmentSubmission::with('assignment_document')->where(['id' => $media_question_check->id])->get();
                                            }
                                        }

                                        $media_question_check = AssignmentSubmission::where(['assignment_id' => $assig_data->id,'user_id' => $request->student_id])->first();
                                        //  dd($media_question_check);
                                        $media_question=[];
                                        if($media_question_check){

                                            $is_submit = $media_question_check->is_submit;
                                           
                                            if($media_question_check->question_id != 0){
                                                $media_question_details = AssignmentSubmission::where(['id' => $media_question_check->id])->get();

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

                                                   $media_question[] = ['id' => $value_media_question->id,'user_id' => $value_media_question->user_id,'assignment_id' => $value_media_question->assignment_id,'question_id' => $value_media_question->question_id,'answer' => $value_media_question->answer,'created_at' => $value_media_question->created_at,'updated_at' => $value_media_question->updated_at,'assignment_documents' => $assignment_documents_question];
                                                }
                                            }
                                        }




                                        // if($assig_data->question_id != 0){
                                        //     $media_question = AssignmentSubmission::with('assignment_document')->where(['assignment_id' => $assig_data->id,'question_id' => 
                                        //         $value_assignment->question_id])->get();
                                                   
                                        // }

                                     

                                        $assignment_question[] = ['id' => $value_assignment->id,'assignment_id' => $value_assignment->assignment_id,'semester_id' => $value_assignment->semester_id,'unit_id' => $value_assignment->unit_id,'question_id' => $value_assignment->question_id,'question_type' => $value_assignment->question_type,'marks' => $value_assignment->marks,'created_at' => $value_assignment->created_at,'updated_at' => $value_assignment->updated_at,'is_submited' => $is_submited,'media' => $media_question,'question' => $value_assignment->question];
                                    }    
                                }
                                

                                $assignment[] = ['id' => $assig_data->id,'user_id' => $assig_data->user_id,'class_id' => $assig_data->class_id,'assignment_type' => $assig_data->assignment_type,'subject_id' => $assig_data->subject_id,'mode' => $assig_data->mode,'title' => $assig_data->title,'assignment_details' => $assig_data->assignment_details,'assignment_date' => $assig_data->assignment_date,'assignment_time' => $assig_data->assignment_time,'due_date' => $assig_data->due_date,'due_time' => $assig_data->due_time,'total_questions' => $assig_data->total_questions,'total_marks' => $assig_data->total_marks,'assignment_image' => $assig_data->assignment_image,'assignment_option' => $assig_data->assignment_option,'water_mark' => $assig_data->water_mark,'footer' => $assig_data->footer,'instruction' => $assig_data->instruction,'font_size' => $assig_data->font_size,'marks_on' => $assig_data->marks_on,'created_at' => $assig_data->created_at,'updated_at' => $assig_data->updated_at,'total_submission' => $total_submission,'is_submit' => $is_submit,'assignment_image_url' => 
                                    $assignment_img,'media' => $media_assignment,'assignment_question' => $assignment_question];

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

                

            }else{
                $assignment_details = Assignment::with('assignment_question')->where(['class_id' => $request->class_id])->get();
                $assignment=[];
                if(count($assignment_details) > 0){
                    foreach ($assignment_details as $key => $value) {
                       $total_submission =  0; 
                       $assignment_img = '';
                       $is_submit = 0;
                       if($value->assignment_image){
                        $assignment_img =  config('ramdoot.appurl')."/upload/assignment_image/".$value->assignment_image;
                        }
                       $assignment[] = Assignment::with('assignment_question','assignment_question.question')->where('id',$value->id)->select('*',DB::raw("CONCAT('$total_submission') AS total_submission"),DB::raw("CONCAT('$is_submit') AS is_submit"),DB::raw("CONCAT('$assignment_img') AS assignment_image_url"))->first();
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
        
        $check_assignment = Assignment::where(['id' => $request->assignment_id])->first();
        if($check_assignment){
            if(count($get_student) > 0){
                for ($i=0; $i < count($get_student); $i++) { 
                    $add_ques = new AssignmentStudent;
                    $add_ques->assignment_id = $request->assignment_id;
                    $add_ques->student_id = $get_student[$i];
                    $add_ques->save();
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

            

            return response()->json([
                "code" => 200,
                "message" => "success"
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
            

            return response()->json([
                "code" => 200,
                "message" => "success"
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

            AssignmentSubmission::where(['user_id' => $request->user_id,'assignment_id' => $request->assignment_id])->update(['is_submit' => 1]);    

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

            AssignmentSubmission::where(['user_id' => $request->user_id,'assignment_id' => $request->assignment_id])->update(['is_submit' => 3]);    

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

                    $assig_data = Assignment::where(['id' => $value->assignment_id])->first();
                   
                   if($assig_data){

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


                        $total_submission =  0; 
                       $assignment_img = '';
                       if($assig_data->assignment_image){
                        $assignment_img =  config('ramdoot.appurl')."/upload/assignment_image/".$assig_data->assignment_image;
                        }
                        $is_submited=0;

                        $get_assignment_question = AssignmentQuestion::with('question')->where(['assignment_id' => $assig_data->id])->get();
                        $assignment_question=[];$is_submit=0;
                        if(count($get_assignment_question) > 0){
                            foreach ($get_assignment_question as $key_assignment => $value_assignment) {

                                $check_submit_question = AssignmentSubmission::where(['user_id' => $request->student_id,'assignment_id' => $value->assignment_id,'question_id' => $value_assignment->question_id])->first();
                                $is_submited = 0;
                                if($check_submit_question){
                                    $is_submited = 1;
                                }

                                $media_question_check = AssignmentSubmission::where(['assignment_id' => $assig_data->id,'user_id' => $request->student_id,'question_id' => $value_assignment->question_id])->first();
                                $media_question=[];
                                if($media_question_check){
                                   
                                    if($media_question_check->question_id != 0){
                                        $media_question = AssignmentSubmission::with('assignment_document')->where(['id' => $media_question_check->id])->get();
                                    }
                                }


                                $media_question_check = AssignmentSubmission::where(['assignment_id' => $assig_data->id,'user_id' => $request->student_id])->first();
                                //dd($media_question_check);
                                $media_question=[];
                                if($media_question_check){

                                    $is_submit = $media_question_check->is_submit;
                                   
                                    if($media_question_check->question_id != 0){
                                        $media_question_details = AssignmentSubmission::where(['id' => $media_question_check->id])->get();

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

                                           $media_question[] = ['id' => $value_media_question->id,'user_id' => $value_media_question->user_id,'assignment_id' => $value_media_question->assignment_id,'question_id' => $value_media_question->question_id,'answer' => $value_media_question->answer,'teacher_id' => $value_media_question->teacher_id,'marks' => $value_media_question->marks,'comment' => $value_media_question->comment,'emoji' => $value_media_question->emoji,'created_at' => $value_media_question->created_at,'updated_at' => $value_media_question->updated_at,'assignment_documents' => $assignment_documents_question];
                                        }
                                    }
                                }




                                // if($assig_data->question_id != 0){
                                //     $media_question = AssignmentSubmission::with('assignment_document')->where(['assignment_id' => $assig_data->id,'question_id' => 
                                //         $value_assignment->question_id])->get();
                                           
                                // }

                             

                                $assignment_question[] = ['id' => $value_assignment->id,'assignment_id' => $value_assignment->assignment_id,'semester_id' => $value_assignment->semester_id,'unit_id' => $value_assignment->unit_id,'question_id' => $value_assignment->question_id,'question_type' => $value_assignment->question_type,'marks' => $value_assignment->marks,'created_at' => $value_assignment->created_at,'updated_at' => $value_assignment->updated_at,'is_submited' => $is_submited,'media' => $media_question,'question' => $value_assignment->question];
                            }    
                        }
                        

                        $assignment[] = ['id' => $assig_data->id,'user_id' => $assig_data->user_id,'class_id' => $assig_data->class_id,'assignment_type' => $assig_data->assignment_type,'subject_id' => $assig_data->subject_id,'mode' => $assig_data->mode,'title' => $assig_data->title,'assignment_details' => $assig_data->assignment_details,'assignment_date' => $assig_data->assignment_date,'assignment_time' => $assig_data->assignment_time,'due_date' => $assig_data->due_date,'due_time' => $assig_data->due_time,'total_questions' => $assig_data->total_questions,'total_marks' => $assig_data->total_marks,'assignment_image' => $assig_data->assignment_image,'assignment_option' => $assig_data->assignment_option,'water_mark' => $assig_data->water_mark,'footer' => $assig_data->footer,'instruction' => $assig_data->instruction,'font_size' => $assig_data->font_size,'marks_on' => $assig_data->marks_on,'created_at' => $assig_data->created_at,'updated_at' => $assig_data->updated_at,'total_submission' => $total_submission,'is_submit' => $is_submit,'assignment_image_url' => 
                            $assignment_img,'media' => $media_assignment,'assignment_question' => $assignment_question];

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

        $check_class = Classroom::where(['id' => $request->class_id])->first();

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
                            $assig_data = TeacherAssignment::where(['id' => $value->assignment_id,'user_id' => $value->student_id,'class_id' => $request->class_id])->first();
                           //dd($assig_data);
                           if($assig_data){

                               // $get_assignment_list = TeacherAssignment::where(['id' => $assig_data->id])->get();


                              //  foreach ($get_assignment_list as $key => $value) {
                                    $assignment_img = '';
                                    if($assig_data->assignment_image){
                                        $assignment_img =  config('ramdoot.appurl')."/upload/assignment_image/".$assig_data->assignment_image;
                                    }
                                        
                                    $get_document = TeacherAssignmentDocument::where(['teacher_assignment_id' => $value->assignment_id])->get();
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


        // $doc_path='';
        // if($value_get_doc->document){
        //     $doc_path =   config('ramdoot.appurl')."/upload/assignment_document/".$value_get_doc->document;
        // }

    }

    

    
    
}

