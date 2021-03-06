<?php

namespace App\Http\Controllers;

use App\Models\exam_question;
use Illuminate\Http\Request;
use App\Models\exam;
use App\Models\question;
use App\Models\Board;

class ExamQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examquestion_details = exam_question::where('status','Active')->groupBy('exam_id')->get();
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
        $exams = exam::where('status','Active')->get();
        $questions = question::where('status','Active')->get();
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
                $add = new exam_question;
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
    public function show(exam_question $exam_question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\exam_question  $exam_question
     * @return \Illuminate\Http\Response
     */
    public function edit(exam_question $exam_question,$id)
    {
        $exams = exam::where('status','Active')->get();
        $questions = question::where('status','Active')->get();
        $boards = Board::where('status','Active')->get();
        $exam_questiondata = exam_question::where('id',$id)->first();
        return view('exam_question.edit',compact('exam_questiondata','exams','questions','boards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\exam_question  $exam_question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, exam_question $exam_question,$id)
    {
        $this->validate($request, [
            'exam_id'     => 'required',
            'question_id' => 'required',
        ]);

        $update = exam_question::find($id);
        $update->exam_id = $request->exam_id;
        $update->question_id = $request->question_id;
        $update->save();

        return redirect()->route('exam_question.index')->with('success', 'Exam Question Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\exam_question  $exam_question
     * @return \Illuminate\Http\Response
     */
    public function distroy(exam_question $exam_question,$id)
    {
        $delete = exam_question::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('exam_question.index')->with('success', 'Exam Question Deleted Successfully.');
    }

    public function getExamDetail(Request $request){

        $getexam_detail = exam::where('id',$request->exam_id)->first();

        $getexam = question::where(['standard_id' => $getexam_detail->standard_id,'semester_id' => $getexam_detail->semester_id,'subject_id' => $getexam_detail->subject_id,'unit_id' => $getexam_detail->unit_id])->inRandomOrder()->take($getexam_detail->total_question)->get();

        // dd($getexam_detail);
        $html=view('exam_question.dynamic_exam_detail',compact('getexam_detail','getexam'))->render();


        return response()->json(['html'=> $html,'getexam_detail' => $getexam_detail]); 
    }

    public function getQuestionView(Request $request){

        $getexam_detail = exam::where('id',$request->exam_id)->first();

        $srno = $request->sr_no;

        $getexam = question::where(['standard_id' => $getexam_detail->standard_id,'semester_id' => $getexam_detail->semester_id,'subject_id' => $getexam_detail->subject_id,'unit_id' => $getexam_detail->unit_id])->get();

        if($srno == 0){
            $chk_limit = $getexam_detail->total_question;
        }else{
            $chk_limit = 1;    
        }
        

        $html=view('exam_question.dynamic_question_model',compact('getexam_detail','getexam','chk_limit','srno'))->render();
        return response()->json(['success'=>true,'html'=>$html,'srno' => $srno]);
    }

    public function getQuestionChange(Request $request){

       $getexam_detail = exam::where('id',$request->exam_id)->first();

       if($request->srno != "0"){
            $change_question_key = $request->srno - 1;
            $getexam=[];
            foreach ($request->hidden_question_id as $key => $value) {
               
               if($change_question_key == $key){
                    $getexam[] = question::where(['id' => $request->select_question_id[0]])->first();
               }
               else{
                    $getexam[] = question::where(['id' => $value])->first();
               }
            } 
       }else{
            foreach ($request->select_question_id as $key => $value) {
                $getexam[] = question::where(['id' => $value])->first();
            }
       }

       $html=view('exam_question.dynamic_exam_detail',compact('getexam_detail','getexam'))->render();
        return response()->json(['html'=> $html,'getexam_detail' => $getexam_detail]); 
    }
    // $get_question = question::where(['unit_id' => $request->unit_id])->inRandomOrder()->limit($request->no_of_question)->get();

    public function getQuestionClear(Request $request){
        $getexam_detail = exam::where('id',$request->exam_id)->first();
       
       $getexam=[];
       
       $html=view('exam_question.dynamic_exam_detail',compact('getexam_detail','getexam'))->render();
        return response()->json(['html'=> $html,'getexam_detail' => $getexam_detail]); 
    }

    public function viewExamList(Request $request){
        $getexam_detail = exam::where('id',$request->exam_id)->first();
        $getexam = exam_question::where('exam_id',$request->exam_id)->get();
        $html=view('exam_question.dynamic_question_list_model',compact('getexam_detail','getexam'))->render();
        return response()->json(['html'=> $html,'getexam_detail' => $getexam_detail]); 
    }
}
