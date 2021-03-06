<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Standard;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:Subject-view', ['only' => ['index']]);
        $this->middleware('permission:Subject-add', ['only' => ['create','store']]);
        $this->middleware('permission:Subject-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:Subject-delete', ['only' => ['distroy']]);
    }
    public function index()
    {
        $subject_details = Subject::where('status','!=','Deleted')->groupBy('standard_id')->get();
        return view('subject.index',compact('subject_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        
        if($id > 0){
            
            $boards = Board::where('status','Active')->get();
            $standards = Standard::where('status','Active')->get();            
            $isset = 1;
            $subject_details = Subject::where(['standard_id' => $id])->where('status','!=','Deleted')->orderBy('order_no','asc')->get();
            $standard_id=$id;
            return view('subject.add',compact('boards','standards','subject_details','isset','id','standard_id'));
        }
        else{            
            $boards = Board::where('status','Active')->get();
            $standards = Standard::where('status','Active')->get();            
            $isset = 0;
            $standard_id=0;
            $subject_details = Subject::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
            return view('subject.add',compact('boards','standards','subject_details','isset','standard_id'));
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
            'subject_name' => 'required',
            'sub_title' => 'required|regex:/^[0-9A-Za-z.\-_]+$/|max:60'
        ]);

        if($request->hidden_id != "0")
        {
            $new_name='';
            if($request->thumbnail_file_type == 'Server'){

                if($request->has('thumbnail'))
                {
                
                    $image = $request->file('thumbnail');

                    $new_name = rand() . '.' . $image->getClientOriginalExtension();

                    $valid_ext = array('png','jpeg','jpg');

                    // Location
                    $location = public_path('upload/subject/thumbnail/').$new_name;

                    $file_extension = pathinfo($location, PATHINFO_EXTENSION);
                    $file_extension = strtolower($file_extension);

                    if(in_array($file_extension,$valid_ext)){
                        $this->compressImage($image->getPathName(),$location,60);
                    }
                }
                else{
                    $new_name = $request->hidden_thumbnail;
                }
            }
            else{
                $new_name = $request->thumbnail;
            }

            $add = Subject::find($request->hidden_id);
            $add->board_id = $request->board_id;
            $add->medium_id = $request->medium_id;
            $add->standard_id = $request->standard_id;
            
            $add->subject_name = $request->subject_name;
            $add->sub_title = $request->sub_title;
            //$add->url = $url_file;
            $add->thumbnail = $new_name;
            $add->thumbnail_file_type = $request->thumbnail_file_type;
            $add->save();
            
            $msg = "Subject Updated Successfully.";
        }
        else{
            $new_name='';
            if($request->thumbnail_file_type == 'Server'){
                if($request->has('thumbnail'))
                {
                
                    $image = $request->file('thumbnail');

                    $new_name = rand() . '.' . $image->getClientOriginalExtension();

                    $valid_ext = array('png','jpeg','jpg');

                    // Location
                    $location = public_path('upload/subject/thumbnail/').$new_name;

                    $file_extension = pathinfo($location, PATHINFO_EXTENSION);
                    $file_extension = strtolower($file_extension);

                    if(in_array($file_extension,$valid_ext)){
                        $this->compressImage($image->getPathName(),$location,60);
                    }
                }
            }
            else{
                $new_name = $request->thumbnail;
            }

            $last_data=Subject::select('*')->where('standard_id',$request->standard_id)->orderBy('order_no','desc')->first();
            if($last_data)
            {
              $last_no=intval($last_data->order_no)+1;
            } 
            else
            {
              $last_no=1;
            }

            $add = new Subject;
            $add->board_id = $request->board_id;
            $add->medium_id = $request->medium_id;
            $add->standard_id = $request->standard_id;            
            $add->subject_name = $request->subject_name;
            $add->sub_title = $request->sub_title;
            $add->order_no=$last_no;            
            $add->thumbnail = $new_name;
            $add->thumbnail_file_type = $request->thumbnail_file_type;
            $add->save();

            $msg = "Subject Added Successfully.";

            storeLog('subject',$add->id,date('Y-m-d H:i:s'),'create');
            storeReview('subject',$add->id,date('Y-m-d H:i:s'));
        }

        $subject_details = Subject::where(['standard_id' => $request->standard_id])->where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        $html = view('subject.dynamic_table',compact('subject_details'))->render();
        $data = ['html' => $html,'message' => $msg];
        return response()->json($data);
        //return redirect()->route('subject.index')->with('success', 'Subject Added Successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $subjectdata = Subject::where('id',$request->id)->first();
        $sem_data=[];        
        $data = ['subject_details' => $subjectdata];        
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject,$id)
    {
        $this->validate($request, [
            'board_id'     => 'required',
            'medium_id'  => 'required',            
            'standard_id'  => 'required',
            'subject_name' => 'required',
            'sub_title' => 'required|regex:/^[0-9A-Za-z.\-_]+$/|max:60'
        ]);

        $new_name='';
        if($request->has('thumbnail'))
        {
        
            $image = $request->file('thumbnail');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/subject/thumbnail/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }
        else{
            $new_name = $request->hidden_thumbnail;
        }

        // $url_file='';
        // if($request->has('url'))
        // {
        //     $image = $request->file('url');
        //     $url_file = time().'.'.$image->getClientOriginalExtension();
        //     $destinationPath = public_path('upload/subject/url/');
        //     $image->move($destinationPath, $url_file);
        // }
        // else{
        //     $url_file = $request->hidden_url;
        // }

        $update = Subject::find($id);
        $update->board_id = $request->board_id;
        $update->medium_id = $request->medium_id;
        $update->standard_id = $request->standard_id;        
        $update->subject_name = $request->subject_name;
        $update->sub_title = $request->sub_title;
        $update->thumbnail = $new_name;
        $update->save();

        return redirect()->route('subject.index')->with('success', 'Subject Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function distroy(Request $request)
    {

        if($request->has('status')){
          if($request->status == "Active"){
            $delete = Subject::find($request->id);
            $delete->status = "Inactive";
            $delete->save();
          }
          else{
            $delete = Subject::find($request->id);
            $delete->status = "Active";
            $delete->save();  
          }
        }else{
            $delete = Subject::find($request->id);
            $delete->status = "Deleted";
            $delete->save();

            delete_order('subjects',$request->id);
        }
        $subject_details = Subject::where(['standard_id' => $request->standard_id])->where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        return view('subject.dynamic_table',compact('subject_details'));

        //return redirect()->route('subject.index')->with('success', 'Subject Deleted Successfully.');
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

    public function getSubject(Request $request){

        $getsubject = Subject::where(['board_id' => $request->board_id,'standard_id' => $request->standard_id,'medium_id' => $request->medium_id,'status' => 'Active'])->orderBy('order_no','asc')->get();

        $result="<option value=''>--Select Subject--</option>";
        if(count($getsubject) > 0)
        {
            foreach ($getsubject as $subject) {

                if($request->has('subject_id')){
                    if($request->subject_id == $subject->id){
                        $result.="<option value='".$subject->id."' selected>".$subject->subject_name."</option>";
                    }
                    else{
                        $result.="<option value='".$subject->id."'>".$subject->subject_name."</option>";    
                    }
                }else{
                    $result.="<option value='".$subject->id."'>".$subject->subject_name."</option>";
                }
            }
        }
        return response()->json(['html'=>$result]);   
    }

    public function get_excel_subject(Request $request){

        $getsubject = Subject::where(['board_id' => $request->board_id,'standard_id' => $request->standard_id,'medium_id' => $request->medium_id,'status' => 'Active'])->orderBy('order_no','asc')->get();

        $result="<option value=''>--Select Subject--</option><option value='All'>All</option>";
        if(count($getsubject) > 0)
        {
            foreach ($getsubject as $subject) {

                if($request->has('subject_id')){
                    if($request->subject_id == $subject->id){
                        $result.="<option value='".$subject->id."' selected>".$subject->subject_name."</option>";
                    }
                    else{
                        $result.="<option value='".$subject->id."'>".$subject->subject_name."</option>";    
                    }
                }else{
                    $result.="<option value='".$subject->id."'>".$subject->subject_name."</option>";
                }
            }
        }
        return response()->json(['html'=>$result]);   
    }

    
    public function load_autocomplete(request $request)
    {
        $response=[];
        
        // $lead_detail=Medicine::where('instruction_english', 'like', '%' . $request['query'] . '%')->where('instruction_english','!=',' ')->where('instruction_english','!=',null)->get();

        $lead_detail=Subject::where('subject_name', 'like', '%' . $request['query'] . '%')->get();
        

        if(count($lead_detail) > 0)
        {
            foreach ($lead_detail as $value) {
                $response[] = array("value"=>$value->subject_name,"data"=>$value->subject_name);
            }   
        }
        return json_encode(array("suggestions" => $response));
    }
    public function load_autocomplete_sub_title(request $request)
    {
        $response=[];
        
        // $lead_detail=Medicine::where('instruction_english', 'like', '%' . $request['query'] . '%')->where('instruction_english','!=',' ')->where('instruction_english','!=',null)->get();

        $lead_detail=Subject::where('sub_title', 'like', '%' . $request['query'] . '%')->get();
        

        if(count($lead_detail) > 0)
        {
            foreach ($lead_detail as $value) {
                $response[] = array("value"=>$value->sub_title,"data"=>$value->sub_title);
            }   
        }
        return json_encode(array("suggestions" => $response));
    }    
    public function above_order(request $request)
    {
        if($request->has('standard_id') && intval($request->standard_id) != null)
        {
            above_order('subjects',$request->order_no,'standard_id',$request->standard_id);    
        }
        else
        {
            above_order('subjects',$request->order_no);
        }
        $subject_details = Subject::where('status','Active')->orderBy('order_no','asc')->get();
        $html = view('subject.dynamic_table',compact('subject_details'))->render();
        $data = ['html' => $html];
        return response()->json($data);
    }
    public function below_order(request $request)
    {
        if($request->has('standard_id') && intval($request->standard_id) != null)
        {
            below_order('subjects',$request->order_no,'standard_id',$request->standard_id);
        }
        else
        {
            below_order('subjects',$request->order_no);   
        }
        $subject_details = Subject::where('status','Active')->orderBy('order_no','asc')->get();
        $html = view('subject.dynamic_table',compact('subject_details'))->render();
        $data = ['html' => $html];
        return response()->json($data);
    }

}
