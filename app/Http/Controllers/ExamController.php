<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Board;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:view-exam', ['only' => ['index']]);
        $this->middleware('permission:add-exam', ['only' => ['create','store']]);
        $this->middleware('permission:edit-exam', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-exam', ['only' => ['distroy']]);
    }
    public function index()
    {
        $exam_details = Exam::where('status','Active')->get();
        return view('exam.index',compact('exam_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $boards = Board::where('status','Active')->get();
        $units = Unit::where('status','Active')->get();
        return view('exam.add',compact('units','boards'));
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
            'board_id' => 'required',
            'medium_id'  => 'required',
            'standard_id' => 'required',
            'semester_id'  => 'required',
            'subject_id' => 'required',
            'unit_id'     => 'required',
            'name' => 'required',
            'time_duration' => 'required',
            'exam_date' => 'required',
            'total_marks' => 'required',
            'total_question' => 'required',
            'start_time' => 'required',
            'end_time' => 'required', 
        ]);

        
        $add = new Exam;
        $add->board_id = $request->board_id;
        $add->medium_id = $request->medium_id;
        $add->standard_id = $request->standard_id;
        $add->semester_id = $request->semester_id;
        $add->subject_id = $request->subject_id;
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
    public function show(Exam $exam)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam,$id)
    {
        $units = Unit::where('status','Active')->get();
        $boards = Board::where('status','Active')->get();
        $examdata = Exam::where('id',$id)->first();
        return view('exam.edit',compact('examdata','units','boards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam,$id)
    {
        $this->validate($request, [
            'board_id' => 'required',
            'medium_id'  => 'required',
            'standard_id' => 'required',
            'semester_id'  => 'required',
            'subject_id' => 'required',
            'unit_id'     => 'required',
            'name' => 'required',
            'time_duration' => 'required',
            'exam_date' => 'required',
            'total_marks' => 'required',
            'total_question' => 'required',
            'start_time' => 'required',
            'end_time' => 'required', 
        ]);

        
        $update = Exam::find($id);
        $update->board_id = $request->board_id;
        $update->medium_id = $request->medium_id;
        $update->standard_id = $request->standard_id;
        $update->semester_id = $request->semester_id;
        $update->subject_id = $request->subject_id;
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
    public function distroy(Exam $exam,$id)
    {
        $delete = Exam::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('exam.index')->with('success', 'Exam Deleted Successfully.');
    }

    

    public function getExam(Request $request){

       //$getunit = Unit::where(['unit_id' => $request->board_id])->get();
       $getexam = Exam::where(['standard_id' => $request->standard_id,'semester_id' => $request->semester_id,'subject_id' => $request->subject_id,'unit_id' => $request->unit_id])->get();

        $result="<option value=''>--Select Exam--</option>";
        if(count($getexam) > 0)
        {
            foreach ($getexam as $exam) {

                if($request->has('exam_id')){
                    if($request->exam_id == $exam->id){
                        $result.="<option value='".$exam->id."' selected>".$exam->name."</option>";
                    }
                    else{
                        $result.="<option value='".$exam->id."'>".$exam->name."</option>";    
                    }
                }else{
                    $result.="<option value='".$exam->id."'>".$exam->name."</option>";
                }
            }
        }
        return response()->json(['html'=>$result]); 
    }
}
