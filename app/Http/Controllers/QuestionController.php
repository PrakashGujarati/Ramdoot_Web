<?php

namespace App\Http\Controllers;

use App\Models\question;
use Illuminate\Http\Request;
use App\Models\unit;


class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $question_details = question::where('status','Active')->get();
        return view('question.index',compact('question_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = unit::where('status','Active')->get();
        return view('question.add',compact('units'));
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
            'unit_id'     => 'required',
            'question' => 'required',
            'note' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'answer' => 'required',
            'per_question_marks' => 'required', 
        ]);

        
        $add = new question;
        $add->unit_id = $request->unit_id;
        $add->note = $request->note;
        $add->question = $request->question;
        $add->option_a = $request->option_a;
        $add->option_b = $request->option_b;
        $add->option_c = $request->option_c;
        $add->option_d = $request->option_d;
        $add->answer = $request->answer;
        $add->per_question_marks = $request->per_question_marks;
        $add->save();

        return redirect()->route('question.index')->with('success', 'Question Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(question $question,$id)
    {
        $units = unit::where('status','Active')->get();
        $questiondata = question::where('id',$id)->first();
        return view('question.edit',compact('questiondata','units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, question $question,$id)
    {
        $this->validate($request, [
            'unit_id'     => 'required',
            'question' => 'required',
            'note' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'answer' => 'required',
            'per_question_marks' => 'required', 
        ]);

        
        $update = question::find($id);
        $update->unit_id = $request->unit_id;
        $update->note = $request->note;
        $update->question = $request->question;
        $update->option_a = $request->option_a;
        $update->option_b = $request->option_b;
        $update->option_c = $request->option_c;
        $update->option_d = $request->option_d;
        $update->answer = $request->answer;
        $update->per_question_marks = $request->per_question_marks;
        $update->save();

        return redirect()->route('question.index')->with('success', 'Question Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\question  $question
     * @return \Illuminate\Http\Response
     */
    public function distroy(question $question,$id)
    {
        $delete = question::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('question.index')->with('success', 'Question Deleted Successfully.');
    }
}
