<?php

namespace App\Http\Controllers;

use App\Models\solution;
use Illuminate\Http\Request;
use App\Models\unit;
use Auth;

class SolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $solution_details = solution::where('status','Active')->get();
        return view('solution.index',compact('solution_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = unit::where('status','Active')->get();
        return view('solution.add',compact('units'));
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
            'answer' => 'required',
            'marks' => 'required',
            'image'  => 'required',
            'label' => 'required',    
        ]);

        $new_name='';
        if($request->has('image'))
        {
        
            $image = $request->file('image');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/solution/thumbnail/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }

        $add = new solution;
        $add->user_id  = Auth::user()->id;
        $add->unit_id = $request->unit_id;
        $add->question = $request->question;
        $add->answer = $request->answer;
        $add->image = $new_name;
        $add->marks = $request->marks;
        $add->label = $request->label;
        $add->save();

        return redirect()->route('solution.index')->with('success', 'Solution Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\solution  $solution
     * @return \Illuminate\Http\Response
     */
    public function show(solution $solution)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\solution  $solution
     * @return \Illuminate\Http\Response
     */
    public function edit(solution $solution,$id)
    {
        $units = unit::where('status','Active')->get();
        $solutiondata = solution::where('id',$id)->first();
        return view('solution.edit',compact('solutiondata','units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\solution  $solution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, solution $solution,$id)
    {
        $this->validate($request, [
            'unit_id'     => 'required',
            'question' => 'required',
            'answer' => 'required',
            'marks' => 'required',
            'label' => 'required',
        ]);

        $new_name='';
        if($request->has('image'))
        {
        
            $image = $request->file('image');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/solution/thumbnail/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }
        else{
            $new_name = $request->hidden_image;
        }

        $update = solution::find($id);
        $update->user_id  = Auth::user()->id;
        $update->unit_id = $request->unit_id;
        $update->question = $request->question;
        $update->answer = $request->answer;
        $update->image = $new_name;
        $update->marks = $request->marks;
        $update->label = $request->label;
        $update->save();

        return redirect()->route('solution.index')->with('success', 'Solution Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\solution  $solution
     * @return \Illuminate\Http\Response
     */
    public function distroy(solution $solution,$id)
    {
        $delete = solution::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('solution.index')->with('success', 'Solution Deleted Successfully.');
    }

    function compressImage($source, $destination, $quality) {
      $info = getimagesize($source);

      if ($info['mime'] == 'image/jpeg') 
        $image = imagecreatefromjpeg($source);

      elseif ($info['mime'] == 'image/gif') 
        $image = imagecreatefromgif($source);

      elseif ($info['mime'] == 'image/png') 
        $image = imagecreatefrompng($source);

      imagejpeg($image, $destination, $quality);
    }
}
