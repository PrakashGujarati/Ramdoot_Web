<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\unit;
use DB;
use Validator;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\semester;
use App\Models\pdf_bookmark;
use App\Models\feature;
use App\Models\pdf_view;
use App\Models\User;
use App\Models\exam;
use App\Models\exam_student;
use App\Models\exam_question;
use App\Models\question;
use App\Models\student_question_answer;

class ExamController extends Controller
{
    public function listOfExams(Request $request){

    	$rules = array(
            'standard_id' => 'required',
            'semester_id' => 'required',
            'subject_id' => 'required',
            'student_id' => 'required',
        );
        $messages = array(
        	'standard_id.required' => 'Please enter standard id.',
            'semester_id.required' => 'Please enter semester id.',
            'subject_id.required' => 'Please enter subject id.',
            'student_id.required' => 'Please enter student id.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkstandard = Standard::where(['id' => $request->standard_id,'status' => 'Active'])->first();
        $chksemester = semester::where(['id' => $request->semester_id,'status' => 'Active'])->first();
        $chksuject = Subject::where(['id' => $request->subject_id,'status' => 'Active'])->first();
        $chkuser = User::where(['id' => $request->student_id])->first();

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
        elseif (empty($chkuser)){
        	return response()->json([
    			"code" => 400,
			  	"message" => "User not found.",
			  	"data" => [],
	        ]);
        }
        else{


        	$getexam = exam::where(['standard_id' => $request->standard_id,'semester_id' => $request->semester_id,'subject_id' => $request->subject_id,'status' => 'Active'])->get();
        	$examdata=[];
        	if(count($getexam) > 0){
        		foreach ($getexam as $value) {
        			
        			$getunit = unit::where(['id' => $value->unit_id,'status' => 'Active'])->first();

        			$chk_student = exam_student::where(['exam_id' => $value->id,'user_id' => $request->student_id])->first();

        			if(empty($chk_student)){

        				//$chk_student = User::where(['id' => $request->student_id])->first();

        				$examdata[] = ['id' => $value->id,'standard_idrd' => isset($chkstandard->standard) ? $chkstandard->standard:'','semester' => isset($chksemester->semester) ? $chksemester->semester:'','suject' => $chksuject->subject_name,'name' => $value->name,'note' => $value->note,'time_duration' => $value->time_duration,'exam_date' =>  $value->exam_date,'total_marks' => $value->total_marks,'total_question' => $value->total_question,'start_time' => $value->start_time,'end_time' => $value->end_time,'negative_marks' => $value->negative_marks];	
        			}
        		}
        		return response()->json([
	    			"code" => 200,
				  	"message" => "success",
				  	"data" => $examdata,
		        ]);
        		
        	}
        	else{
        		return response()->json([
	    			"code" => 400,
				  	"message" => "Exam details not found.",
	 			  	"data" => [],
		        ]);
        	}
		
        }

    }

    public function examQuestions(Request $request){

    	$rules = array(
            'exam_id' => 'required',
            'student_id' => 'required',
            'ip_address' => 'required'
        );
        $messages = array(
        	'exam_id.required' => 'Please enter standard id.',
            'student_id.required' => 'Please enter semester id.',
            'ip_address.required' => 'Please enter subject id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $getexam = exam::where(['id' => $request->exam_id,'status' => 'Active'])->first();
        $check_student = User::where(['id' => $request->student_id])->first();

        if(empty($getexam)){

        	return response()->json([
    			"code" => 400,
			  	"message" => "Exam not found.",
			  	"data" => [],
	        ]);
        }
        elseif(empty($check_student)){
        	return response()->json([
    			"code" => 400,
			  	"message" => "Student not found.",
			  	"data" => [],
	        ]);
        }
        else{
       		$get_exam_question = exam_question::where(['exam_id' => $request->exam_id,'status' => 'Active'])->get(); 	

       		if(count($get_exam_question) > 0){
       			foreach ($get_exam_question as $question_data) {

       				$get_question =  question::where(['id' => $question_data->question_id])->first();

       				if($get_question){
       					$is_true_a=0;$is_true_b=0;$is_true_c=0;$is_true_d=0;
		        		if($get_question->answer == "A"){
		        			$is_true_a=1; 
		        		}elseif($get_question->answer == "B"){
		        			$is_true_b=1;
		        		}elseif($get_question->answer == "C"){
		        			$is_true_c=1;
		        		}elseif($get_question->answer == "D"){
		        			$is_true_d=1;
		        		}

		        		$data[] = ['id' => $get_question->id,'question' => $get_question->question,'answer' => $get_question->answer,'mark' => $get_question->per_question_marks,'options' => [['option' => $get_question->option_a,'is_true' => $is_true_a],['option' => $get_question->option_b,'is_true' => $is_true_b],['option' => $get_question->option_c,'is_true' => $is_true_c],['option' => $get_question->option_d,'is_true' => $is_true_d]]];	
       				}
       			}

       			date_default_timezone_set('Asia/Kolkata');
       			$add = new exam_student;
       			$add->exam_id = $getexam->id;
       			$add->user_id = $request->student_id;
       			$add->start_time = date('Y-m-d H:i:s');
       			$add->ip_address = $request->ip_address;
       			$add->save(); 



       			return response()->json([
	    			"code" => 200,
				  	"message" => "success",
	 			  	"data" => ['exam_student_id' => $add->id,'questions' => $data],
		        ]);

       		}
       		else{
       			return response()->json([
	    			"code" => 400,
				  	"message" => "Exam Question not found.",
	 			  	"data" => [],
		        ]);
       		}
        }
    	
    }

    public function submitExam(Request $request){	
    	$rules = array(
            'exam_id' => 'required',
            'student_id' => 'required',
            'exam_students_id' => 'required',
            'questions' => 'required',
            'answers' => 'required',
        );
        $messages = array(
        	'exam_id.required' => 'Please enter standard id.',
            'student_id.required' => 'Please enter semester id.',
            'exam_students_id.required' => 'Please enter exam student id.',
            'questions.required' => 'Please enter questions.',
            'answers.required' => 'Please enter answers.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $questions_arr = explode(',',$request->questions);
        $answer_arr = explode(',',$request->answers);

        date_default_timezone_set('Asia/Kolkata');


        $check_exam = exam::where(['id' => $request->exam_id,'status' => 'Active'])->first();
        $check_student = User::where(['id' => $request->student_id])->first();
        $check_exam_student = exam_student::where(['id' => $request->exam_students_id,'status' => 'Active'])->first();

        if(empty($check_exam)){
        	return response()->json([
    			"code" => 400,
			  	"message" => "Exam not found.",
			  	"data" => [],
	        ]);
        }
        elseif(empty($check_student)){
        	return response()->json([
    			"code" => 400,
			  	"message" => "Student not found.",
			  	"data" => [],
	        ]);
        }
        elseif(empty($check_exam_student)){
        	return response()->json([
    			"code" => 400,
			  	"message" => "Exam student details not found.",
			  	"data" => [],
	        ]);
        }
        else{
        	$total_mark = 0;
        	if(count($questions_arr) > 0){
				for ($que=0; $que < count($questions_arr); $que++) {
										
					$get_question_detail =  question::where(['id' => $questions_arr[$que]])->first();
						
					if($get_question_detail->answer == $answer_arr[$que]){
						$total_mark = $total_mark + $get_question_detail->per_question_marks;
					}
				}
			}

     	$update = exam_student::find($request->exam_students_id);
		$update->end_time = date('Y-m-d H:i:s');
		$update->is_attend = 1;
		$update->is_agree = 1;
		$update->result = $total_mark;
		$update->save();

		if(count($questions_arr) > 0){
			for ($que=0; $que < count($questions_arr); $que++) {
				$add =  new student_question_answer;
				$add->exam_student_id = $request->exam_students_id;
				$add->question_id = $questions_arr[$que];
				$add->answer = $answer_arr[$que];
				$add->save();
			}
		}
			

		return response()->json([
			"code" => 200,
		  	"message" => "success",
			"data" => [],
        ]);

        }
    }

    public function resultExam(Request $request){
    	$rules = array(
            'exam_id' => 'required',
            'student_id' => 'required'
        );
        $messages = array(
        	'exam_id.required' => 'Please enter standard id.',
            'student_id.required' => 'Please enter semester id.'
        );

        $check_exam = exam::where(['id' => $request->exam_id,'status' => 'Active'])->first();
        $check_student = User::where(['id' => $request->student_id])->first();

        if(empty($check_exam)){

        	return response()->json([
    			"code" => 400,
			  	"message" => "Exam not found.",
			  	"data" => [],
	        ]);
        }
        elseif(empty($check_student)){
        	return response()->json([
    			"code" => 400,
			  	"message" => "Student not found.",
			  	"data" => [],
	        ]);
        }
        else{
        	$get_result = exam_student::where(['exam_id' => $request->exam_id,'user_id' => $request->student_id])->first();


        	$get_student_exam_details = student_question_answer::where(['exam_student_id' => $get_result->id])->get();

        	$totalquestion=0;$notattemt=0;$attemptquestion=0;$obtainedmarks=0;$totalmarks=0;$takentime;$attemptexamdatetime;
        	if(count($get_student_exam_details) > 0){
				foreach ($get_student_exam_details as $key => $value) {
					$getquestion = question::where(['id' => $value->question_id])->first();
					$totalquestion = $totalquestion + 1;
					$totalmarks = $totalmarks + $getquestion->per_question_marks;

					if($value->answer == "N"){
						$notattemt = $notattemt + 1;
					}
					else{
						$attemptquestion = $attemptquestion + 1;
					}
				}
			}

			return response()->json([
    			"code" => 400,
			  	"message" => "Student not found.",
			  	"data" => ['totalquestion' => $totalquestion,'notattemt' => $notattemt,'attemptquestion' => $attemptquestion,'obtainedmarks' => (int)$get_result->result,'totalmarks' => $totalmarks,'takentime' => '','attemptexamdatetime' => $get_result->start_time],
	        ]);
        	//dd($totalquestion,$total_marks);

        }
    }
}
