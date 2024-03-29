<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Medium;
use App\Models\Standard;
use App\Models\Subject;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:Semester-view', ['only' => ['index']]);
        $this->middleware('permission:Semester-add', ['only' => ['create','store']]);
        $this->middleware('permission:Semester-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:Semester-delete', ['only' => ['distroy']]);
    }
    public function index()
    {
        $semester_details = Semester::where('status','!=','Deleted')->groupBy('subject_id')->get();
        return view('semester.index',compact('semester_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        if($id != null){
            
            $boards = Board::where('status','Active')->get();
            $standards = Standard::where('status','Active')->get();
            $subjects = Subject::where('status','Active')->get();
            $subject_details = Subject::where(['id' => $id])->first();
            $isset = 1;
            $semester_details = Semester::where(['subject_id' => $id])->where('status','!=','Deleted')->orderBy('order_no','asc')->get();
            return view('semester.add',compact('boards','standards','semester_details','isset','subject_details'));
        }
        else{
            $boards = Board::where('status','Active')->get();
            $standards = Standard::where('status','Active')->get();
            $subjects = Subject::where('status','Active')->get();
            $subject_details = [];
            $isset = 0;
            $semester_details = Semester::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
            return view('semester.add',compact('boards','standards','semester_details','isset','subject_details'));
        }
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
            'sub_title' => 'required|regex:/^[0-9A-Za-z.\-_]+$/|max:60'
        ]);

        if($request->hidden_id != "0"){
            $add = Semester::find($request->hidden_id);
            $add->board_id = $request->board_id;
            $add->medium_id = $request->medium_id;
            $add->standard_id = $request->standard_id;
            $add->subject_id = $request->subject_id;
            $add->semester = $request->semester;
            $add->sub_title = $request->sub_title;
            $add->save();

            $msg = "Semester Updated Successfully.";
        }
        else{

            $last_data=Semester::select('*')->where('subject_id',$request->subject_id)->orderBy('order_no','desc')->first();
            if($last_data)
            {
              $last_no=intval($last_data->order_no)+1;
            } 
            else
            {
              $last_no=1;
            }

            $add = new Semester;
            $add->board_id = $request->board_id;
            $add->medium_id = $request->medium_id;
            $add->standard_id = $request->standard_id;
            $add->subject_id = $request->subject_id;
            $add->semester = $request->semester;
            $add->sub_title = $request->sub_title;
            $add->order_no=$last_no;
            $add->save();

            storeLog('semester',$add->id,date('Y-m-d H:i:s'),'create');
            storeReview('semester',$add->id,date('Y-m-d H:i:s'));

            $msg = "Semester Added Successfully.";
        }
                

        $semester_details = Semester::where(['subject_id' => $request->subject_id])->where('status','!=','Deleted')->orderBy('order_no','asc')->get();
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
            'sub_title' => 'required|regex:/^[0-9A-Za-z.\-_]+$/|max:60'
        ]);

        $update = Semester::find($id);
        $update->board_id = $request->board_id;
        $update->medium_id = $request->medium_id;
        $update->standard_id = $request->standard_id;
        $update->standard_id = $request->standard_id;        
        $update->semester = $request->semester;
        $update->sub_title = $request->sub_title;
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

        if($request->has('status')){
          if($request->status == "Active"){
            $delete = Semester::find($request->id);
            $delete->status = "Inactive";
            $delete->save();
          }
          else{
            $delete = Semester::find($request->id);
            $delete->status = "Active";
            $delete->save();  
          }
        }else{
            $delete = Semester::find($request->id);
            $delete->status = "Deleted";
            $delete->save();
            delete_order('semesters',$request->id);
        }

        $semester_details = Semester::where(['standard_id' => $request->standard_id])->where('status','!=','Deleted')->orderBy('order_no','asc')->get();
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

        $getsemester = Semester::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,'standard_id' => $request->standard_id,'status' => 'Active'])->orderBy('order_no','asc')->get();

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

        $getsemester = Semester::where(["board_id" => $request->board_id,"medium_id" => $request->medium_id,
            "standard_id" => $request->standard_id,"subject_id" => $request->subject_id,'status' => 'Active'])->orderBy('order_no','asc')->get();

        $result="<option value=''>--Select Semester--</option><option value='0'>No Semester</option>";
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

    public function get_excel_semester(Request $request){

        $getsemester = Semester::where(["board_id" => $request->board_id,"medium_id" => $request->medium_id,
            "standard_id" => $request->standard_id,"subject_id" => $request->subject_id,'status' => 'Active'])->orderBy('order_no','asc')->get();

        $result="<option value=''>--Select Semester--</option><option value='All'>All</option>";
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
    public function above_order(request $request)
    {
        if($request->has('standard_id') && $request->standard_id != null)
        {
            above_order('semesters',$request->order_no,'standard_id',$request->standard_id);
        }
        else
        {
            above_order('semesters',$request->order_no);
        }

        $semester_details = Semester::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        $html = view('semester.dynamic_table',compact('semester_details'))->render();
        $data = ['html' => $html];
        return response()->json($data);
    }
    public function below_order(request $request)
    {
        if($request->has('standard_id') && $request->standard_id != null)
        {
            below_order('semesters',$request->order_no,'standard_id',$request->standard_id);
        }
        else
        {
            below_order('semesters',$request->order_no);    
        }
        
        $semester_details = Semester::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        $html = view('semester.dynamic_table',compact('semester_details'))->render();
        $data = ['html' => $html];
        return response()->json($data);
    }

}
