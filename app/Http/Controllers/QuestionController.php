<?php

namespace App\Http\Controllers;

use App\Models\question;
use Illuminate\Http\Request;
use App\Models\unit;
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
        $boards = Board::where('status','Active')->get();
        return view('question.add',compact('units','boards'));
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
            'note' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'answer' => 'required',
            'per_question_marks' => 'required', 
        ]);

        for ($i = 0; $i < count($request->question); $i++) {
        
        $add = new question;
        $add->board_id = $request->board_id;
        $add->medium_id = $request->medium_id;
        $add->standard_id = $request->standard_id;
        $add->semester_id = $request->semester_id;
        $add->subject_id = $request->subject_id;
        $add->unit_id = $request->unit_id;
        $add->note = $request->note[$i];
        $add->question = $request->question[$i];
        $add->option_a = $request->option_a[$i];
        $add->option_b = $request->option_b[$i];
        $add->option_c = $request->option_c[$i];
        $add->option_d = $request->option_d[$i];
        $add->answer = $request->answer[$i];
        $add->per_question_marks = $request->per_question_marks[$i];
        $add->level = $request->level[$i];
        $add->save();

        }


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
        $boards = Board::where('status','Active')->get();
        $questiondata = question::where('id',$id)->first();
        return view('question.edit',compact('questiondata','units','boards'));
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

        
        $update = question::find($id);
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
    public function distroy(question $question,$id)
    {
        $delete = question::find($id);
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


