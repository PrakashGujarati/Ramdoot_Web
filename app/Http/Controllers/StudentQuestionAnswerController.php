<?php

namespace App\Http\Controllers;

use App\Models\student_question_answer;
use Illuminate\Http\Request;

class StudentQuestionAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student_question_answer_details = student_question_answer::all();
        return view('exam_student_question_answer.index',compact('student_question_answer_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\student_question_answer  $student_question_answer
     * @return \Illuminate\Http\Response
     */
    public function show(student_question_answer $student_question_answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\student_question_answer  $student_question_answer
     * @return \Illuminate\Http\Response
     */
    public function edit(student_question_answer $student_question_answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\student_question_answer  $student_question_answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, student_question_answer $student_question_answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\student_question_answer  $student_question_answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(student_question_answer $student_question_answer)
    {
        //
    }
}
