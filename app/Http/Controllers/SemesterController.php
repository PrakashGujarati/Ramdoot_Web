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
    public function __construct()
    {
        $this->middleware('permission:view-semester', ['only' => ['index']]);
        $this->middleware('permission:add-semester', ['only' => ['create','store']]);
        $this->middleware('permission:edit-semester', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-semester', ['only' => ['distroy']]);
    }
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
        $semester_details = Semester::where('status','Active')->get();
        return view('semester.add',compact('boards','standards','semester_details'));
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

        if($request->hidden_id != "0"){
            $add = Semester::find($request->hidden_id);
            $add->board_id = $request->board_id;
            $add->medium_id = $request->medium_id;
            $add->standard_id = $request->standard_id;
            $add->semester = $request->semester;
            $add->save();

            $msg = "Semester Updated Successfully.";
        }
        else{
            $add = new Semester;
            $add->board_id = $request->board_id;
            $add->medium_id = $request->medium_id;
            $add->standard_id = $request->standard_id;
            $add->semester = $request->semester;
            $add->save();

            storeLog('semester',$add->id,date('Y-m-d H:i:s'),'create');
            storeReview('semester',$add->id,date('Y-m-d H:i:s'));

            $msg = "Semester Added Successfully.";
        }
                

        $semester_details = Semester::where('status','Active')->get();
        $html = view('semester.dynamic_table',compact('semester_details'))->render();
        $data = ['html' => $html,'message' => $msg];
        return response()->json($data);


        
        //return view('semester.dynamic_table',compact('semester_details'));
        //return redirect()->route('semester.index')->with('success', 'Semester Added Successfully.');
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
    public function edit(Request $request)
    {
        $semesterdata = Semester::where('id',$request->id)->first();
        return $semesterdata;
        //$boards = Board::where('status','Active')->get();
        //$standards = Standard::where('status','Active')->get();
       // return view('semester.edit',compact('semesterdata','boards','standards'));
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
    public function distroy(Request $request)
    {
        $delete = Semester::find($request->id);
        $delete->status = "Deleted";
        $delete->save();

        $semester_details = Semester::where('status','Active')->get();
        return view('semester.dynamic_table',compact('semester_details'));
        //return redirect()->route('semester.index')->with('success', 'Semester Deleted Successfully.');
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
    public function load_autocomplete(request $request)
    {
        $response=[];
        
        // $lead_detail=Medicine::where('instruction_english', 'like', '%' . $request['query'] . '%')->where('instruction_english','!=',' ')->where('instruction_english','!=',null)->get();

        $lead_detail=Semester::where('semester', 'like', '%' . $request['query'] . '%')->get();
        

        if(count($lead_detail) > 0)
        {
            foreach ($lead_detail as $value) {
                $response[] = array("value"=>$value->semester,"data"=>$value->semester);
            }   
        }
        return json_encode(array("suggestions" => $response));
    }
}
