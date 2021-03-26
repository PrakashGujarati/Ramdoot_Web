<?php

namespace App\Http\Controllers;

use App\Models\Mcq;
use Illuminate\Http\Request;
use App\Models\Unit;
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
        $mcq_details = Mcq::where('status','Active')->get();
        return view('mcq.index',compact('mcq_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Unit::where('status','Active')->get();
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

        
        $add = new Mcq;
        $add->unit_id = $request->unit_id;
        $add->question = $request->question;
        $add->opt1 = $request->opt1;
        $add->opt2 = $request->opt2;
        $add->opt3 = $request->opt3;
        $add->opt4 = $request->opt4;
        $add->answer = $request->answer;
        $add->level = $request->level;
        $add->save();
        storeLog('mcq',$add->id,date('Y-m-d H:i:s'),'create');
        storeReview('mcq',$add->id,date('Y-m-d H:i:s'));
        return redirect()->route('mcq.index')->with('success', 'MCQ Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\mcq  $mcq
     * @return \Illuminate\Http\Response
     */
    public function show(Mcq $mcq)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\mcq  $mcq
     * @return \Illuminate\Http\Response
     */
    public function edit(Mcq $mcq,$id)
    {
        $units = Unit::where('status','Active')->get();
        $mcqdata = Mcq::where('id',$id)->first();
        return view('mcq.edit',compact('mcqdata','units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\mcq  $mcq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mcq $mcq,$id)
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

        
        $add = Mcq::find($id);
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
    public function distroy(Mcq $mcq,$id)
    {
        $delete = Mcq::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('mcq.index')->with('success', 'MCQ Deleted Successfully.');
    }
}
