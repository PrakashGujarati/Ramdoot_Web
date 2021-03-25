<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Board;
use Excel;
use App\Imports\QuestionImport;
use App\Exports\QuestionExport;
use Session;


class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:view-question', ['only' => ['index']]);
        $this->middleware('permission:add-question', ['only' => ['create','store']]);
        $this->middleware('permission:edit-question', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-question', ['only' => ['distroy']]);
    }
    public function index()
    {
        $question_details = Question::where('status','Active')->get();
        return view('question.index',compact('question_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Unit::where('status','Active')->get();
        $boards = Board::where('status','Active')->get();
        $question_details = Question::where('status','Active')->get();
        return view('question.add',compact('units','boards','question_details'));
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
            'question' => 'required',
            // 'note' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'answer' => 'required',
            'per_question_marks' => 'required', 
        ]);

        // for ($i = 0; $i < count($request->question); $i++) {
        
        $add = new Question;
        $add->board_id = $request->board_id;
        $add->medium_id = $request->medium_id;
        $add->standard_id = $request->standard_id;
        $add->semester_id = $request->semester_id;
        $add->subject_id = $request->subject_id;
        $add->unit_id = $request->unit_id;
        $add->note = $request->note;
        $add->question = $request->question;
        $add->option_a = $request->option_a;
        $add->option_b = $request->option_b;
        $add->option_c = $request->option_c;
        $add->option_d = $request->option_d;
        $add->answer = $request->answer;
        $add->per_question_marks = $request->per_question_marks;
        $add->level = $request->level;
        $add->save();

        $question_details = Question::where('status','Active')->get();
        return view('question.dynamic_table',compact('question_details'));
        // }


        //return redirect()->route('question.index')->with('success', 'Question Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question,$id)
    {
        $units = Unit::where('status','Active')->get();
        $boards = Board::where('status','Active')->get();
        $questiondata = Question::where('id',$id)->first();
        return view('question.edit',compact('questiondata','units','boards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question,$id)
    {
        $this->validate($request, [
            'board_id' => 'required',
            'medium_id'  => 'required',
            'standard_id' => 'required',
            'semester_id'  => 'required',
            'subject_id' => 'required',
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

        
        $update = Question::find($id);
        $update->board_id = $request->board_id;
        $update->medium_id = $request->medium_id;
        $update->standard_id = $request->standard_id;
        $update->semester_id = $request->semester_id;
        $update->subject_id = $request->subject_id;
        $update->unit_id = $request->unit_id;
        $update->note = $request->note;
        $update->question = $request->question;
        $update->option_a = $request->option_a;
        $update->option_b = $request->option_b;
        $update->option_c = $request->option_c;
        $update->option_d = $request->option_d;
        $update->answer = $request->answer;
        $update->per_question_marks = $request->per_question_marks;
        $update->level = $request->level;
        $update->save();

        return redirect()->route('question.index')->with('success', 'Question Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\question  $question
     * @return \Illuminate\Http\Response
     */
    public function distroy(Question $question,$id)
    {
        $delete = Question::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('question.index')->with('success', 'Question Deleted Successfully.');
    }

    public function importQuestionView(){

        $boards = Board::where('status','Active')->get();
        $html=view('question.dynamic_import_model',compact('boards'))->render();
        return response()->json(['success'=>true,'html'=>$html]);
    }

    public function questionExport()
    {
        $data=[];
         return Excel::download(new QuestionExport($data), 'Questions.xlsx');        
    }

    public function questionImport(Request $request){

        $allowed = array('csv', 'xls', 'xlsx');
        $filename = $_FILES['file']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            Session::flash('error','Please select valid file.');
            return redirect()->route('question.index');
        }
        else{
            Excel::import(new QuestionImport($request), request()->file('file')); 
            return redirect()->route('question.index');    
        }

        
    }

}


