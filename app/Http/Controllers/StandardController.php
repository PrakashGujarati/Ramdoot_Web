<?php

namespace App\Http\Controllers;

use App\Models\Standard;
use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Medium;

class StandardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:Standard-view', ['only' => ['index']]);
        $this->middleware('permission:Standard-add', ['only' => ['create','store']]);
        $this->middleware('permission:Standard-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:Standard-delete', ['only' => ['distroy']]);
    }
    
    public function index()
    {
        $standard_details = Standard::where('status','!=','Deleted')->groupBy('medium_id')->get();
        return view('standard.index',compact('standard_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        if($id != null){
            $standard_details = Standard::where(['medium_id' => $id])->where('status','!=','Deleted')->orderBy('order_no','asc')->get();
            $boards = Board::where('status','Active')->get();
            $isset = 1;
            $medium_details = Medium::where(['id' => $id])->first();
            return view('standard.add',compact('boards','standard_details','medium_details','isset'));
        }
        else{
            $standard_details = Standard::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
            $boards = Board::where('status','Active')->get();
            $isset = 0;
            $medium_details = [];
            return view('standard.add',compact('boards','standard_details','medium_details','isset'));
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
            'standard'  => 'required',
            'section' => 'required'
        ]);


        if($request->hidden_id != "0"){

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

            $add = Standard::find($request->hidden_id);
            $add->medium_id = $request->medium_id;
            $add->board_id = $request->board_id;
            $add->standard = $request->standard;
            $add->section = $request->section;
            $add->thumbnail = $new_name;
            $add->save();

            $msg = "Standard Updated Successfully.";
        }
        else{

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
            $last_data=Standard::select('*')->orderBy('order_no','asc')->first();
            if($last_data)
            {
                $last_number=intval($last_data->order_no)+1;
            }
            else
            {
                $last_number=1;
            }
            $add = new Standard;
            $add->medium_id = $request->medium_id;
            $add->board_id = $request->board_id;
            $add->standard = $request->standard;
            $add->section = $request->section;
            $add->thumbnail = $new_name;
            $add->order_no=$last_number;
            $add->save();

            storeLog('standard',$add->id,date('Y-m-d H:i:s'),'create');
            storeReview('standard',$add->id,date('Y-m-d H:i:s'));

            $msg = "Standard Added Successfully.";

        }

        $standard_details = Standard::where(['medium_id' => $request->medium_id])->where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        $html = view('standard.dynamic_table',compact('standard_details'))->render();
        $data = ['html' => $html,'message' => $msg];
        return response()->json($data);

        
        //return view('standard.dynamic_table',compact('standard_details'));
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
    public function edit(Request $request)
    {
        $standarddata = Standard::where('id',$request->id)->first();
        return $standarddata;
        //$boards = Board::where('status','Active')->get();
        //return view('standard.edit',compact('standarddata','boards'));
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
    public function distroy(Request $request)
    {
        if($request->has('status')){
            if($request->status == "Active"){
            $delete = Standard::find($request->id);
            $delete->status = "Inactive";
            $delete->save();
          }
          else{
            $delete = Standard::find($request->id);
            $delete->status = "Active";
            $delete->save();  
          }

        }else{
            $delete = Standard::find($request->id);
            $delete->status = "Deleted";
            $delete->save();
            delete_order('standards',$request->id);    
        }
        

        $standard_details = Standard::where(['medium_id' => $request->medium_id])->where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        return view('standard.dynamic_table',compact('standard_details'));
        //return redirect()->route('standard.index')->with('success', 'Standard Deleted Successfully.');
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

        $getstandard = Standard::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,'status' => 'Active'])->orderBy('order_no','asc')->get();

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


    public function get_excel_Standard(Request $request){

        $getstandard = Standard::where(['board_id' => $request->board_id,'medium_id' => $request->medium_id,'status' => 'Active'])->orderBy('order_no','asc')->get();

        $result="<option value=''>--Select Standard--</option><option value='All'>All</option>";
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


    public function load_autocomplete(request $request)
    {
        $response=[];
        
        // $lead_detail=Medicine::where('instruction_english', 'like', '%' . $request['query'] . '%')->where('instruction_english','!=',' ')->where('instruction_english','!=',null)->get();

        $lead_detail=Standard::where('standard', 'like', '%' . $request['query'] . '%')->get();
        

        if(count($lead_detail) > 0)
        {
            foreach ($lead_detail as $value) {
                $response[] = array("value"=>$value->standard,"data"=>$value->standard);
            }   
        }
        return json_encode(array("suggestions" => $response));
    }
    public function load_autocomplete_section(request $request)
    {
        $response=[];
        
        // $lead_detail=Medicine::where('instruction_english', 'like', '%' . $request['query'] . '%')->where('instruction_english','!=',' ')->where('instruction_english','!=',null)->get();

        $lead_detail=Standard::where('section', 'like', '%' . $request['query'] . '%')->get();
        

        if(count($lead_detail) > 0)
        {
            foreach ($lead_detail as $value) {
                $response[] = array("value"=>$value->section,"data"=>$value->section);
            }   
        }
        return json_encode(array("suggestions" => $response));
    }
    public function above_order(request $request)
    {
        above_order('standards',$request->order_no);

        $standard_details = Standard::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        $html = view('standard.dynamic_table',compact('standard_details'))->render();
        $data = ['html' => $html];
        return response()->json($data);
    }
    public function below_order(request $request)
    {
        below_order('standards',$request->order_no);
        $standard_details = Standard::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        $html = view('standard.dynamic_table',compact('standard_details'))->render();
        $data = ['html' => $html];
        return response()->json($data);
    }
}

