<?php

namespace App\Http\Controllers;

use App\Models\unit;
use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Standard;
use App\Models\semester;
use App\Models\Subject;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unit_details = unit::where('status','Active')->get();
        return view('unit.index',compact('unit_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $semesters = semester::where('status','Active')->get();
        $standards = Standard::where('status','Active')->get();
        $subjects = Subject::where('status','Active')->get();
        return view('unit.add',compact('subjects','standards','semesters'));
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
            'standard_id'  => 'required',
            'semester_id' => 'required',
            'subject_id' => 'required',
            'title' => 'required',
            'url' => 'required',
            'thumbnail' => 'required',
        ]);

        $new_name='';
        if($request->has('thumbnail'))
        {
        
            $image = $request->file('thumbnail');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/unit/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }

        $add = new unit;
        $add->standard_id = $request->standard_id;
        $add->semester_id = $request->semester_id;
        $add->subject_id = $request->subject_id;
        $add->title = $request->title;
        $add->url = $request->url;
        $add->thumbnail = $new_name;
        $add->save();

        return redirect()->route('unit.index')->with('success', 'Unit Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(unit $unit,$id)
    {
        $unitdata = unit::where('id',$id)->first();
        $subjects = Subject::where('status','Active')->get();
        $semesters = semester::where('status','Active')->get();
        $standards = Standard::where('status','Active')->get();
        return view('unit.edit',compact('unitdata','subjects','semesters','standards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, unit $unit,$id)
    {
        $this->validate($request, [
            'standard_id'  => 'required',
            'semester_id' => 'required',
            'subject_id' => 'required',
            'title' => 'required',
            'url' => 'required',
        ]);

        $new_name='';
        if($request->has('thumbnail'))
        {
        
            $image = $request->file('thumbnail');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/unit/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }
        else{
            $new_name = $request->hidden_thumbnail;
        }

        $update = unit::find($id);
        $update->standard_id = $request->standard_id;
        $update->semester_id = $request->semester_id;
        $update->subject_id = $request->subject_id;
        $update->title = $request->title;
        $update->url = $request->url;
        $update->thumbnail = $new_name;
        $update->save();

        return redirect()->route('unit.index')->with('success', 'Unit Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function distroy(unit $unit,$id)
    {
        $delete = unit::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('unit.index')->with('success', 'Unit Deleted Successfully.');
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
