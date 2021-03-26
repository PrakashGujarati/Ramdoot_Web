<?php

namespace App\Http\Controllers;

use App\Models\exam_student;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\User;
use Auth;

class ExamStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:view-exam-result', ['only' => ['index']]);
    }
    public function index(Request $request)
    {
        $exams = Exam::where('status','Active')->get();
        $examstudent_details = exam_student::where('status','Active')->get();
        if($request->ajax())
        {
            if($request->exam_id != null){
                $examstudent_details = exam_student::where(['exam_id' => $request->exam_id,'status' => 'Active'])->get();    
            }else{
                $examstudent_details = exam_student::where(['status' => 'Active'])->get();
            }

            $html=view('exam_student.dynamic_table',compact('examstudent_details'))->render();
            return response()->json(['html'=>$html]);

        }

        return view('exam_student.index',compact('examstudent_details','exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $exams = Exam::where('status','Active')->get();
        $users = User::where('id','!=',Auth::user()->id)->where('name','!=','')->get();
        return view('exam_student.add',compact('exams','users'));
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
            'exam_id' => 'required',
            'student_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            
        ]);

        
        $add = new exam_student;
        $add->exam_id = $request->exam_id;
        $add->user_id = $request->student_id;
        $add->start_time = $request->start_time;
        $add->end_time = $request->end_time;
        $add->remaining_time = isset($request->remaining_time) ? $request->remaining_time:null;
        $add->result = isset($request->result) ? $request->result:null;
        $add->node_number = isset($request->node_number) ? $request->node_number:null;
        $add->is_attend = isset($request->is_attend) ? $request->is_attend:0;
        $add->save();
        storeLog('exam_student',$add->id,date('Y-m-d H:i:s'),'create');
        storeReview('exam_student',$add->id,date('Y-m-d H:i:s'));

        return redirect()->route('exam_student.index')->with('success', 'Student Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\exam_student  $exam_student
     * @return \Illuminate\Http\Response
     */
    public function show(exam_student $exam_student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\exam_student  $exam_student
     * @return \Illuminate\Http\Response
     */
    public function edit(exam_student $exam_student,$id)
    {
        $exams = Exam::where('status','Active')->get();
        $users = User::where('id','!=',Auth::user()->id)->where('name','!=','')->get();
        $examstudentdata = exam_student::where('id',$id)->first();
        return view('exam_student.edit',compact('examstudentdata','users','exams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\exam_student  $exam_student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, exam_student $exam_student,$id)
    {
        $this->validate($request, [
            'exam_id' => 'required',
            'student_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            
        ]);

        
        $update = exam_student::find($id);
        $update->exam_id = $request->exam_id;
        $update->user_id = $request->student_id;
        $update->start_time = $request->start_time;
        $update->end_time = $request->end_time;
        $update->remaining_time = isset($request->remaining_time) ? $request->remaining_time:null;
        $update->result = isset($request->result) ? $request->result:null;
        $update->node_number = isset($request->node_number) ? $request->node_number:null;
        $update->is_attend = isset($request->is_attend) ? $request->is_attend:0;
        $update->save();

        return redirect()->route('exam_student.index')->with('success', 'Student Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\exam_student  $exam_student
     * @return \Illuminate\Http\Response
     */
    public function distroy(exam_student $exam_student,$id)
    {
        $delete = exam_student::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('exam_student.index')->with('success', 'Student Deleted Successfully.');
    }
}
