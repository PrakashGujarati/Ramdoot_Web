<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medium;
use App\Models\Board;

class MediumController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-medium', ['only' => ['index']]);
        $this->middleware('permission:add-medium', ['only' => ['create','store']]);
        $this->middleware('permission:edit-medium', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-medium', ['only' => ['distroy']]);
    }
	public function index()
    {
        $mediums_details = Medium::where('status','Active')->get();
        return view('medium.index',compact('mediums_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $boards = Board::where('status','Active')->get();
        return view('medium.add',compact('boards'));
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
            'board_id'     => 'required',
            'medium_name' => 'required',
        ]);
//        Medium

        $add = new Medium;
        $add->board_id = $request->board_id;
        $add->medium_name = $request->medium_name;
        $add->save();
        

        return redirect()->route('medium.index')->with('success', 'Medium Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\exam_question  $exam_question
     * @return \Illuminate\Http\Response
     */
    public function show(exam_question $exam_question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\exam_question  $exam_question
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $boards = Board::where('status','Active')->get();
        $mediumdata = Medium::where('id',$id)->first();

        return view('medium.edit',compact('boards','mediumdata'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\exam_question  $exam_question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $this->validate($request, [
            'board_id'     => 'required',
            'medium_name' => 'required',
        ]);

        $add = Medium::find($id);
        $add->board_id = $request->board_id;
        $add->medium_name = $request->medium_name;
        $add->save();

        return redirect()->route('medium.index')->with('success', 'Medium Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\exam_question  $exam_question
     * @return \Illuminate\Http\Response
     */
    public function distroy($id)
    {
        $delete = Medium::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('medium.index')->with('success', 'Medium Deleted Successfully.');
    }    


    public function getMedium(Request $request)
    {
    	$getmedium = Medium::where(['board_id' => $request->board_id,'status' => 'Active'])->get();

        $result="<option value=''>--Select Medium--</option>";
        if(count($getmedium) > 0)
        {
            foreach ($getmedium as $medium) {

                if($request->has('medium_id')){
                    if($request->medium_id == $medium->id){
                        $result.="<option value='".$medium->id."' selected>".$medium->medium_name."</option>";
                    }
                    else{
                        $result.="<option value='".$medium->id."'>".$medium->medium_name."</option>";    
                    }
                }else{
                    $result.="<option value='".$medium->id."'>".$medium->medium_name."</option>";
                }
            }
        }
        return response()->json(['html'=>$result]);
    }

}
