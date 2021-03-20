<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionType;



class QuestionTypeController extends Controller
{
    public function index()
    {
        $question_type_details = QuestionType::where('status','Active')->get();
        return view('question_type.index',compact('question_type_details'));
    }


    public function create()
    {
        return view('slider.add');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'question_type' => 'required',
        ]);

        if($request->hidden_id == "0"){

        	$add = new QuestionType;
	        $add->question_type = $request->question_type;
	        $add->save();
        }
        else{

        	$update = QuestionType::find($request->hidden_id);
	        $update->question_type = $request->question_type;
	        $update->save();
        }

        $question_type_details = QuestionType::where('status','Active')->get();
        return view('question_type.dynamic_table',compact('question_type_details'));
        //return redirect()->route('slider.index')->with('success', 'Slide Added Successfully.');
    }

    public function edit(Request $request){
    	if($request->has('hidden_id')){
    		$question_type_data = QuestionType::where(['id' => $request->hidden_id,'status' => 'Active'])->first();
    		return $question_type_data;
        	//return view('question_type.dynamic_table',compact('question_type_data'));	
    	}
    }

    public function distroy(Request $request)
    {
        $delete = QuestionType::find($request->hidden_id);
        $delete->status = "Deleted";
        $delete->save();

        $question_type_details = QuestionType::where('status','Active')->get();
        return view('question_type.dynamic_table',compact('question_type_details'));

        //return redirect()->route('slider.index')->with('success', 'Slide Deleted Successfully.');
    }


}
