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

                $checkclass = ClassStudent::where(['user_id' => $request->user_id,'class_id' => $classrooms_arr->id])->first();

                if($checkclass){
                    $add = new ClassStudent;
                    $add->user_id = $request->user_id;
                    $add->class_id = $classrooms_arr->id;
                    $add->status = 'aprove';
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

        //$usercheck = User::where(['id' => $request->user_id])->first();

        // if($usercheck){
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
                    'classroom_id' => $classdetails->classroom_id,'status' => $classdetails->status,'is_aprove' => $aprove];
                }
            }

            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $classrooms,
            ]);
        
        // else{
        //     return response()->json([
        //         "code" => 400,
        //         "message" => "User not found.",
        //         "data" => [],
        //     ]);
        // }


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

        $rules = array(
            'class_id' => 'required',
            'assignment_type' => 'required',
            'question_ids' => 'required',
            'question_type' => 'required',
            'mark_ids' => 'required',
            'is_mcq' => 'required'
        );
        $messages = array(
            'class_id' => 'Please enter class id.',
            'assignment_type' => 'Please enter assignment type.',
            'question_ids' => 'Please enter question ids.',
            'question_type' => 'Please enter question type.',
            'mark_ids' => 'Please enter mark ids.',
            'is_mcq' => 'Please enter mcq status.'
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

        $get_question_details = VirtualAssignmentQuestions::where(['class_id' => $request->class_id,'assignment_type' => $request->assignment_type])->groupby('marks')->get();

        if(count($get_question_details) > 0){
            $counter_array=[];
            foreach ($get_question_details as $key => $value) {
               $getcount = VirtualAssignmentQuestions::where(['marks' => $value->marks,'assignment_type' => $value->assignment_type])->count('id');
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

        $get_question_details = VirtualAssignmentQuestions::where(['class_id' => $request->class_id,'assignment_type' => $request->assignment_type])->groupby('marks')->get();

        if(count($get_question_details) > 0){
            $counter_array=[];
            foreach ($get_question_details as $key => $value) {
                if($value->question_type != 0){
                    $counter_array[] = VirtualAssignmentQuestions::with('question_solution')->where(['marks' => $value->marks,'assignment_type' => $value->assignment_type])->first();     
                } 
                else{
                    $counter_array[] = VirtualAssignmentQuestions::with('question')->where(['marks' => $value->marks,'assignment_type' => $value->assignment_type])->first();
                }
               
               //$counter_array[] = ['marks' => $value->marks,'count' => $getcount];
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
}

