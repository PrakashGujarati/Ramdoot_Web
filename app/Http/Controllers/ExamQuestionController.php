<?php

namespace App\Http\Controllers;

use App\Models\exam_question;
use Illuminate\Http\Request;
use App\Models\exam;
use App\Models\question;

class ExamQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $examquestion_details = exam_question::where('status','Active')->get();
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
        return view('exam_question.add',compact('exams','questions'));
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

        
        $add = new exam_question;
        $add->exam_id = $request->exam_id;
        $add->question_id = $request->question_id;
        $add->save();

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
        $exam_questiondata = exam_question::where('id',$id)->first();
        return view('exam_question.edit',compact('exam_questiondata','exams','questions'));
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
}
