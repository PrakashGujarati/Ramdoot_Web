<?php

namespace App\Http\Controllers;

use App\Models\ExamQuestion;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Board;

class ExamQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:view-exam-question', ['only' => ['index']]);
        $this->middleware('permission:add-exam-question', ['only' => ['create','store']]);
        $this->middleware('permission:edit-exam-question', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-exam-question', ['only' => ['distroy']]);
    }
    public function index()
    {
        $examquestion_details = ExamQuestion::where('status','Active')->groupBy('exam_id')->get();
        //dd(count($examquestion_details));
        return view('exam_question.index',compact('examquestion_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $exams = Exam::where('status','Active')->get();
        $questions = Question::where('status','Active')->get();
        $boards = Board::where('status','Active')->get();
        $getexam_detail = [];
        $getexam = [];
        return view('exam_question.add',compact('exams','questions','boards','getexam_detail','getexam'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'exam_id'     => 'required',
            'question_id' => 'required',
        ]);


        if(count($request->question_id) > 0){
            foreach ($request->question_id as $key => $value) {
                $add = new ExamQuestion;
                $add->exam_id = $request->exam_id;
                $add->question_id = $value;
                $add->save();
            }    
        }

        return redirect()->route('exam_question.index')->with('success', 'Exam Question Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\exam_question  $exam_question
     * @return \Illuminate\Http\Response
     */
    public function show(ExamQuestion $exam_question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\exam_question  $exam_question
     * @return \Illuminate\Http\Response
     */
    public function edit(ExamQuestion $exam_question,$id)
    {
        $exams = Exam::where('status','Active')->get();
        $questions = Question::where('status','Active')->get();
        $boards = Board::where('status','Active')->get();
        //$exam_detail = Exam::where(['id' => $id])->first();
        
        $exam_questiondata = ExamQuestion::where('exam_id',$id)->get();

        $getexam_detail = Exam::where('id',$id)->first();

        $getexam_question_details = ExamQuestion::where('exam_id',$id)->get();

        $getexam=[];
        if(count($getexam_question_details) > 0){
            foreach ($getexam_question_details as $question_data) {
                $getexam[] = Question::where(['id' => $question_data->question_id])->first();
            }
        }

        // $getexam = Question::where(['standard_id' => $getexam_detail->standard_id,'semester_id' => $getexam_detail->semester_id,'subject_id' => $getexam_detail->subject_id,'unit_id' => $getexam_detail->unit_id])->inRandomOrder()->take($getexam_detail->total_question)->get();

        return view('exam_question.edit',compact('exam_questiondata','exams','questions','boards','getexam','getexam_detail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\exam_question  $exam_question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExamQuestion $exam_question,$id)
    {

        // dd($request->all());

        $this->validate($request, [
            'exam_id'     => 'required',
            'question_id' => 'required',
        ]);

        ExamQuestion::where(['exam_id' => $request->exam_id])->delete();

        if(count($request->question_id) > 0){
            foreach ($request->question_id as $key => $value) {
                $add = new ExamQuestion;
                $add->exam_id = $request->exam_id;
                $add->question_id = $value;
                $add->save();
            }    
        }

        // $update = exam_Question::find($id);
        // $update->exam_id = $request->exam_id;
        // $update->question_id = $request->question_id;
        // $update->save();

        return redirect()->route('exam_question.index')->with('success', 'Exam Question Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\exam_question  $exam_question
     * @return \Illuminate\Http\Response
     */
    public function distroy(ExamQuestion $exam_question,$id)
    {
        ExamQuestion::where('exam_id',$id)->update(['status' => 'Deleted']);
        // $delete = exam_Question::find($id);
        // $delete->status = "Deleted";
        // $delete->save();

        return redirect()->route('exam_question.index')->with('success', 'Exam Question Deleted Successfully.');
    }

    public function getExamDetail(Request $request){

        $getexam_detail = Exam::where('id',$request->exam_id)->first();

        $getexam = Question::where(['standard_id' => $getexam_detail->standard_id,'semester_id' => $getexam_detail->semester_id,'subject_id' => $getexam_detail->subject_id,'unit_id' => $getexam_detail->unit_id])->inRandomOrder()->take($getexam_detail->total_question)->get();

        // dd($getexam_detail);
        $html=view('exam_question.dynamic_exam_detail',compact('getexam_detail','getexam'))->render();


        return response()->json(['html'=> $html,'getexam_detail' => $getexam_detail]); 
    }

    public function getQuestionView(Request $request){

        $getexam_detail = Exam::where('id',$request->exam_id)->first();

        $srno = $request->sr_no;

        $getexam = Question::where(['standard_id' => $getexam_detail->standard_id,'semester_id' => $getexam_detail->semester_id,'subject_id' => $getexam_detail->subject_id,'unit_id' => $getexam_detail->unit_id])->get();

        if($srno == 0){
            $chk_limit = $getexam_detail->total_question;
        }else{
            $chk_limit = 1;    
        }
        

        $html=view('exam_question.dynamic_question_model',compact('getexam_detail','getexam','chk_limit','srno'))->render();
        return response()->json(['success'=>true,'html'=>$html,'srno' => $srno]);
    }

    public function getQuestionChange(Request $request){

       $getexam_detail = Exam::where('id',$request->exam_id)->first();

       if($request->srno != "0"){
            $change_question_key = $request->srno - 1;
            $getexam=[];
            foreach ($request->hidden_question_id as $key => $value) {
               
               if($change_question_key == $key){
                    $getexam[] = Question::where(['id' => $request->select_question_id[0]])->first();
               }
               else{
                    $getexam[] = Question::where(['id' => $value])->first();
               }
            } 
       }else{
            foreach ($request->select_question_id as $key => $value) {
                $getexam[] = Question::where(['id' => $value])->first();
            }
       }

       $html=view('exam_question.dynamic_exam_detail',compact('getexam_detail','getexam'))->render();
        return response()->json(['html'=> $html,'getexam_detail' => $getexam_detail]); 
    }
    // $get_question = Question::where(['unit_id' => $request->unit_id])->inRandomOrder()->limit($request->no_of_question)->get();

    public function getQuestionClear(Request $request){
        $getexam_detail = Exam::where('id',$request->exam_id)->first();
       
       $getexam=[];
       
       $html=view('exam_question.dynamic_exam_detail',compact('getexam_detail','getexam'))->render();
        return response()->json(['html'=> $html,'getexam_detail' => $getexam_detail]); 
    }

    public function viewExamList(Request $request){
        $getexam_detail = Exam::where('id',$request->exam_id)->first();
        $getexam = ExamQuestion::where('exam_id',$request->exam_id)->get();
        $html=view('exam_question.dynamic_question_list_model',compact('getexam_detail','getexam'))->render();
        return response()->json(['html'=> $html,'getexam_detail' => $getexam_detail]); 
    }
}
