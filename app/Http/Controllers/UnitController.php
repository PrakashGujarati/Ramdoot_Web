<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Standard;
use App\Models\Semester;
use App\Models\Subject;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:view-unit', ['only' => ['index']]);
        $this->middleware('permission:add-unit', ['only' => ['create','store']]);
        $this->middleware('permission:edit-unit', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-unit', ['only' => ['distroy']]);
    }
    public function index()
    {
        $unit_details = Unit::where('status','Active')->groupBy('subject_id')->get();
        return view('unit.index',compact('unit_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $boards = Board::where('status','Active')->get();
        $semesters = Semester::where('status','Active')->get();
        $standards = Standard::where('status','Active')->get();
        $subjects = Subject::where('status','Active')->get();
        $unit_details = Unit::where('status','Active')->get();
        return view('unit.add',compact('subjects','standards','semesters','boards','unit_details'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());

        $this->validate($request, [
            'board_id'  => 'required',
            'medium_id'  => 'required',
            'standard_id'  => 'required',
            'semester_id' => 'required',
            'subject_id' => 'required',
            // 'title' => 'required',
            // 'url' => 'required',
            // 'thumbnail' => 'required',
            // 'pages' => 'required',
        ]);

        // for ($i = 0; $i < count($request->title); $i++) {

            $new_name='';
            if($request->thumbnail)
            {
            
                $image = $request->thumbnail;

                $new_name = rand() . '.' . $image->getClientOriginalExtension();

                $valid_ext = array('png','jpeg','jpg');

                // Location
                $location = public_path('upload/unit/thumbnail/').$new_name;

                $file_extension = pathinfo($location, PATHINFO_EXTENSION);
                $file_extension = strtolower($file_extension);

                if(in_array($file_extension,$valid_ext)){
                    $this->compressImage($image->getPathName(),$location,60);
                }
            }

            $url_file='';
            if($request->url_type == 'file'){
                if($request->url)
                {
                    $image = $request->url;
                    $url_file = time().'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('upload/unit/url/');
                    $image->move($destinationPath, $url_file);
                }
            }else{
                $url_file = $request->url;
            }

            $add = new Unit;
            $add->board_id = $request->board_id;
            $add->medium_id = $request->medium_id;
            $add->standard_id = $request->standard_id;
            $add->semester_id = $request->semester_id;
            $add->subject_id = $request->subject_id;
            $add->title = $request->title;
            $add->url_type = $request->url_type;
            $add->url = $url_file;
            $add->thumbnail = $new_name;
            $add->pages = isset($request->pages) ? $request->pages:'';
            $add->description = isset($request->description) ? $request->description:'';
            $add->save();
                

           $unit_details = Unit::where('status','Active')->get();
           return view('unit.dynamic_table',compact('unit_details'));
           //return redirect()->route('unit.index')->with('success', 'Unit Added Successfully.');     
        // }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit,$id)
    {
        $unitdata = Unit::where('id',$id)->first();
        $boards = Board::where('status','Active')->get();
        $subjects = Subject::where('status','Active')->get();
        $semesters = Semester::where('status','Active')->get();
        $standards = Standard::where('status','Active')->get();
        return view('unit.edit',compact('unitdata','subjects','semesters','standards','boards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit,$id)
    {
        $this->validate($request, [
            'board_id' => 'required',
            'medium_id'  => 'required',
            'standard_id'  => 'required',
            'semester_id' => 'required',
            'subject_id' => 'required',
            // 'title' => 'required',
            // 'pages' => 'required',
        ]);

        $new_name='';
        if($request->has('thumbnail'))
        {
        
            $image = $request->file('thumbnail');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/unit/thumbnail/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }
        else{
            $new_name = $request->hidden_thumbnail;
        }

        $url_file='';
        if($request->url_type == 'file'){
            if($request->file('url'))
            {
                $image = $request->file('url');
                $url_file = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('upload/unit/url/');
                $image->move($destinationPath, $url_file);
            }
            else{
                $url_file = $request->hidden_url;
            }
        }
        else{
            $url_file = $request->url;
        }

        $update = Unit::find($id);
        $update->board_id = $request->board_id;
        $update->medium_id = $request->medium_id;
        $update->standard_id = $request->standard_id;
        $update->semester_id = $request->semester_id;
        $update->subject_id = $request->subject_id;
        $update->title = $request->title;
        $update->url_type = $request->url_type;
        $update->url = $url_file;
        $update->thumbnail = $new_name;
        $update->pages = isset($request->pages) ? $request->pages:'';
        $update->description = isset($request->description) ? $request->description:'';
        $update->save();

        return redirect()->route('unit.index')->with('success', 'Unit Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function distroy(Unit $unit,$id)
    {
        $delete = Unit::find($id);
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

    public function getUnit(Request $request){

       //$getunit = Unit::where(['unit_id' => $request->board_id])->get();
       $getunit = Unit::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,'standard_id' => $request->standard_id,'semester_id' => $request->semester_id,'subject_id' => $request->subject_id,'status' => 'Active'])->get();

        $result="<option value=''>--Select Unit--</option>";
        if(count($getunit) > 0)
        {
            foreach ($getunit as $unit) {

                if($request->has('unit_id')){
                    if($request->unit_id == $unit->id){
                        $result.="<option value='".$unit->id."' selected>".$unit->title."</option>";
                    }
                    else{
                        $result.="<option value='".$unit->id."'>".$unit->title."</option>";    
                    }
                }else{
                    $result.="<option value='".$unit->id."'>".$unit->title."</option>";
                }
            }
        }
        
        return response()->json(['html'=>$result]); 
    }
}
