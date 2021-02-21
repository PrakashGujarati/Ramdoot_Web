<?php

namespace App\Http\Controllers;

use App\Models\mcq;
use Illuminate\Http\Request;
use App\Models\unit;
use Auth;

class McqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mcq_details = mcq::where('status','Active')->get();
        return view('mcq.index',compact('mcq_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = unit::where('status','Active')->get();
        return view('mcq.add',compact('units'));
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
            'opt1' => 'required',
            'opt2' => 'required',
            'opt3' => 'required',
            'opt4' => 'required',
            'answer' => 'required',
            'level' => 'required', 
        ]);

        
        $add = new mcq;
        $add->unit_id = $request->unit_id;
        $add->question = $request->question;
        $add->opt1 = $request->opt1;
        $add->opt2 = $request->opt2;
        $add->opt3 = $request->opt3;
        $add->opt4 = $request->opt4;
        $add->answer = $request->answer;
        $add->level = $request->level;
        $add->save();

        return redirect()->route('mcq.index')->with('success', 'MCQ Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\mcq  $mcq
     * @return \Illuminate\Http\Response
     */
    public function show(mcq $mcq)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\mcq  $mcq
     * @return \Illuminate\Http\Response
     */
    public function edit(mcq $mcq,$id)
    {
        $units = unit::where('status','Active')->get();
        $mcqdata = mcq::where('id',$id)->first();
        return view('mcq.edit',compact('mcqdata','units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\mcq  $mcq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, mcq $mcq,$id)
    {
        
        $this->validate($request, [
            'unit_id'     => 'required',
            'question' => 'required',
            'opt1' => 'required',
            'opt2' => 'required',
            'opt3' => 'required',
            'opt4' => 'required',
            'answer' => 'required',
            'level' => 'required', 
        ]);

        
        $add = mcq::find($id);
        $add->unit_id = $request->unit_id;
        $add->question = $request->question;
        $add->opt1 = $request->opt1;
        $add->opt2 = $request->opt2;
        $add->opt3 = $request->opt3;
        $add->opt4 = $request->opt4;
        $add->answer = $request->answer;
        $add->level = $request->level;
        $add->save();

        return redirect()->route('mcq.index')->with('success', 'MCQ Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\mcq  $mcq
     * @return \Illuminate\Http\Response
     */
    public function distroy(mcq $mcq,$id)
    {
        $delete = mcq::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('mcq.index')->with('success', 'MCQ Deleted Successfully.');
    }
}
