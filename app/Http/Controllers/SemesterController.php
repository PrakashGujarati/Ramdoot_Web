<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Standard;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semester_details = Semester::where('status','Active')->get();
        return view('semester.index',compact('semester_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $boards = Board::where('status','Active')->get();
        $standards = Standard::where('status','Active')->get();
        return view('semester.add',compact('boards','standards'));
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
            'standard_id'  => 'required',
            'semester' => 'required',
        ]);

        $add = new Semester;
        $add->board_id = $request->board_id;
        $add->medium_id = $request->medium_id;
        $add->standard_id = $request->standard_id;
        $add->semester = $request->semester;
        $add->save();

        return redirect()->route('semester.index')->with('success', 'Semester Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function show(Semester $semester)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function edit(Semester $semester,$id)
    {
        $semesterdata = Semester::where('id',$id)->first();
        $boards = Board::where('status','Active')->get();
        $standards = Standard::where('status','Active')->get();
        return view('semester.edit',compact('semesterdata','boards','standards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Semester $semester,$id)
    {
        $this->validate($request, [
            'board_id'     => 'required',
            'medium_id'  => 'required',
            'standard_id'  => 'required',
            'semester' => 'required',
        ]);

        $update = Semester::find($id);
        $update->board_id = $request->board_id;
        $update->medium_id = $request->medium_id;
        $update->standard_id = $request->standard_id;
        $update->semester = $request->semester;
        $update->save();

        return redirect()->route('semester.index')->with('success', 'Semester Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function distroy(Semester $semester,$id)
    {
        $delete = semester::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('semester.index')->with('success', 'Semester Deleted Successfully.');
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

    public function getSemester(Request $request){

        $getsemester = Semester::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,'standard_id' => $request->standard_id,'status' => 'Active'])->get();

        $result="<option value=''>--Select Semester--</option>";
        if(count($getsemester) > 0)
        {
            foreach ($getsemester as $semester) {

                if($request->has('semester_id')){
                    if($request->semester_id == $semester->id){
                        $result.="<option value='".$semester->id."' selected>".$semester->semester."</option>";
                    }
                    else{
                        $result.="<option value='".$semester->id."'>".$semester->semester."</option>";    
                    }
                }else{
                    $result.="<option value='".$semester->id."'>".$semester->semester."</option>";
                }
            }
        }
        return response()->json(['html'=>$result]);   
    }

    public function getSemesterUnit(Request $request){

        $getsemester = Semester::where(['standard_id' => $request->standard_id,'status' => 'Active'])->get();

        $result="<option value=''>--Select Semester--</option>";
        if(count($getsemester) > 0)
        {
            foreach ($getsemester as $semester) {

                if($request->has('semester_id')){
                    if($request->semester_id == $semester->id){
                        $result.="<option value='".$semester->id."' selected>".$semester->semester."</option>";
                    }
                    else{
                        $result.="<option value='".$semester->id."'>".$semester->semester."</option>";    
                    }
                }else{
                    $result.="<option value='".$semester->id."'>".$semester->semester."</option>";
                }
            }
        }
        return response()->json(['html'=>$result]);   
    }

}
