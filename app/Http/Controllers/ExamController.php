<?php

namespace App\Http\Controllers;

use App\Models\exam;
use Illuminate\Http\Request;
use App\Models\unit;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exam_details = exam::where('status','Active')->get();
        return view('exam.index',compact('exam_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = unit::where('status','Active')->get();
        return view('exam.add',compact('units'));
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
            'name' => 'required',
            'time_duration' => 'required',
            'exam_date' => 'required',
            'total_marks' => 'required',
            'total_question' => 'required',
            'start_time' => 'required',
            'end_time' => 'required', 
        ]);

        
        $add = new exam;
        $add->unit_id = $request->unit_id;
        $add->name = $request->name;
        $add->note = isset($request->note) ? $request->note:'';
        $add->time_duration = $request->time_duration;
        $add->exam_date = $request->exam_date;
        $add->total_marks = $request->total_marks;
        $add->total_question = $request->total_question;
        $add->start_time = $request->start_time;
        $add->end_time = $request->end_time;
        $add->negative_marks = $request->negative_marks;
        $add->exam_status = isset($request->exam_status) ? $request->exam_status:0;
        $add->instant_result = isset($request->instant_result) ? $request->instant_result:0;
        $add->is_minus_system = isset($request->is_minus_system) ? $request->is_minus_system:0;
        $add->save();

        return redirect()->route('exam.index')->with('success', 'Exam Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(exam $exam)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(exam $exam,$id)
    {
        $units = unit::where('status','Active')->get();
        $examdata = exam::where('id',$id)->first();
        return view('exam.edit',compact('examdata','units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, exam $exam,$id)
    {
        $this->validate($request, [
            'unit_id'     => 'required',
            'name' => 'required',
            'time_duration' => 'required',
            'exam_date' => 'required',
            'total_marks' => 'required',
            'total_question' => 'required',
            'start_time' => 'required',
            'end_time' => 'required', 
        ]);

        
        $update = exam::find($id);
        $update->unit_id = $request->unit_id;
        $update->name = $request->name;
        $update->note = isset($request->note) ? $request->note:'';
        $update->time_duration = $request->time_duration;
        $update->exam_date = $request->exam_date;
        $update->total_marks = $request->total_marks;
        $update->total_question = $request->total_question;
        $update->start_time = $request->start_time;
        $update->end_time = $request->end_time;
        $update->negative_marks = $request->negative_marks;
        $update->exam_status = isset($request->exam_status) ? $request->exam_status:0;
        $update->instant_result = isset($request->instant_result) ? $request->instant_result:0;
        $update->is_minus_system = isset($request->is_minus_system) ? $request->is_minus_system:0;
        $update->save();

        return redirect()->route('exam.index')->with('success', 'Exam Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function distroy(exam $exam,$id)
    {
        $delete = exam::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('exam.index')->with('success', 'Exam Deleted Successfully.');
    }
}
