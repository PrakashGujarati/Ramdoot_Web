<?php

namespace App\Http\Controllers;

use App\Models\Standard;
use Illuminate\Http\Request;
use App\Models\Board;

class StandardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:view-standard', ['only' => ['index']]);
        $this->middleware('permission:add-standard', ['only' => ['create','store']]);
        $this->middleware('permission:edit-standard', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-standard', ['only' => ['distroy']]);
    }
    
    public function index()
    {
        $standard_details = Standard::where('status','Active')->get();
        return view('standard.index',compact('standard_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $standard_details = Standard::where('status','Active')->get();
        $boards = Board::where('status','Active')->get();
        return view('standard.add',compact('boards','standard_details'));
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
            'medium_id'  => 'required',
            'standard'  => 'required',
            //'semester' => 'required',
            'section' => 'required',
            'thumbnail'  => 'required',
        ]);

        $new_name='';
        if($request->has('thumbnail'))
        {
        
            $image = $request->file('thumbnail');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/standard/thumbnail/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }

        $add = new Standard;
        $add->medium_id = $request->medium_id;
        $add->board_id = $request->board_id;
        $add->standard = $request->standard;
        $add->section = $request->section;
        $add->thumbnail = $new_name;
        $add->save();

        $standard_details = Standard::where('status','Active')->get();
        return view('standard.dynamic_table',compact('standard_details'));
        //return redirect()->route('standard.index')->with('success', 'Standard Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Standard  $standard
     * @return \Illuminate\Http\Response
     */
    public function show(Standard $standard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Standard  $standard
     * @return \Illuminate\Http\Response
     */
    public function edit(Standard $standard,$id)
    {
        $standarddata = Standard::where('id',$id)->first();
        $boards = Board::where('status','Active')->get();
        return view('standard.edit',compact('standarddata','boards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Standard  $standard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Standard $standard,$id)
    {
        $this->validate($request, [
            'board_id'     => 'required',
            'medium_id'  => 'required',
            'standard'  => 'required',
           // 'semester' => 'required',
            'section' => 'required',
        ]);

        $new_name='';
        if($request->has('thumbnail'))
        {
        
            $image = $request->file('thumbnail');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/standard/thumbnail/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }
        else{
            $new_name = $request->hidden_thumbnail;
        }

        $update = Standard::find($id);
        $update->board_id = $request->board_id;
        $update->medium_id = $request->medium_id;
        $update->standard = $request->standard;
        $update->section = $request->section;
        $update->thumbnail = $new_name;
        $update->save();

        return redirect()->route('standard.index')->with('success', 'Standard Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Standard  $standard
     * @return \Illuminate\Http\Response
     */
    public function distroy(Standard $standard,$id)
    {
        $delete = Standard::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('standard.index')->with('success', 'Standard Deleted Successfully.');
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

    public function getStandard(Request $request){

        $getstandard = Standard::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,'status' => 'Active'])->get();

        $result="<option value=''>--Select Standard--</option>";
        if(count($getstandard) > 0)
        {
            foreach ($getstandard as $standard) {

                if($request->has('standard_id')){
                    if($request->standard_id == $standard->id){
                        $result.="<option value='".$standard->id."' selected>".$standard->standard."</option>";
                    }
                    else{
                        $result.="<option value='".$standard->id."'>".$standard->standard."</option>";    
                    }
                }else{
                    $result.="<option value='".$standard->id."'>".$standard->standard."</option>";
                }
            }
        }
        return response()->json(['html'=>$result]);   
    }
}

