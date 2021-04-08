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
        $mediums_details = Medium::where('status','!=','Deleted')->groupBy('board_id')->get();
        return view('medium.index',compact('mediums_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        if($id != null){
            $mediums_details = Medium::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
            $boards = Board::where('status','Active')->get();
            $boards_details = Board::where('id',$id)->first();
            $isset = 1;
            return view('medium.add',compact('boards','mediums_details','isset','boards_details'));
        }
        else{
            $mediums_details = Medium::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
            $boards = Board::where('status','Active')->get();
            $boards_details = [];
            $isset = 0;
            return view('medium.add',compact('boards','mediums_details','isset','boards_details'));
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
            'medium_name' => 'required',
        ]);
//        Medium

        if($request->hidden_id != "0"){
            $add = Medium::find($request->hidden_id);
            $add->board_id = $request->board_id;
            $add->medium_name = $request->medium_name;
            $add->save();

            $mediums_details = Medium::where('status','Active')->orderBy('order_no','asc')->get();
            $html = view('medium.dynamic_table',compact('mediums_details'))->render();
            $data = ['html' => $html,'message' => 'Medium Update Successfully.'];

        }else{

            $last_data=Medium::select('*')->orderBy('order_no','desc')->first();
            if($last_data)
            {
              $last_no=intval($last_data->order_no)+1;
            } 
            else
            {
              $last_no=1;
            }

            $add = new Medium;
            $add->board_id = $request->board_id;
            $add->medium_name = $request->medium_name;
            $add->order_no=$last_no;
            $add->save();
            
            storeLog('medium',$add->id,date('Y-m-d H:i:s'),'create');
            storeReview('medium',$add->id,date('Y-m-d H:i:s'));

            $mediums_details = Medium::where('status','Active')->orderBy('order_no','asc')->get();
            $html = view('medium.dynamic_table',compact('mediums_details'))->render();
            $data = ['html' => $html,'message' => 'Medium Added Successfully.'];
        }
  
        return response()->json($data);  
        
        $mediums_details = Medium::where('status','!=','Deleted')->get();
        return view('medium.dynamic_table',compact('mediums_details'));
        //return redirect()->route('medium.index')->with('success', 'Medium Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\exam_question  $exam_question
     * @return \Illuminate\Http\Response
     */
    public function show(ExamQuestion $exam_question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\exam_question  $exam_question
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //$boards = Board::where('status','Active')->get();
        $mediumdata = Medium::where('id',$request->id)->first();
        //$data = ['boards' => $boards,'mediumdata' => $mediumdata];
        return $mediumdata;
        //return view('medium.edit',compact('boards','mediumdata'));
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
    public function distroy(Request $request)
    {
        if($request->has('status')){
          if($request->status == "Active"){
            $delete = Medium::find($request->id);
            $delete->status = "Inactive";
            $delete->save();
          }
          else{
            $delete = Medium::find($request->id);
            $delete->status = "Active";
            $delete->save();  
          }
        }else{
            $delete = Medium::find($request->id);
            $delete->status = "Deleted";
            $delete->save();
        }

        $mediums_details = Medium::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        return view('medium.dynamic_table',compact('mediums_details'));
        //return redirect()->route('medium.index')->with('success', 'Medium Deleted Successfully.');
    }    


    public function getMedium(Request $request)
    {
    	$getmedium = Medium::where(['board_id' => $request->board_id,'status' => 'Active'])->orderBy('order_no','asc')->get();

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
    public function load_autocomplete(request $request)
    {
        $response=[];
        
        // $lead_detail=Medicine::where('instruction_english', 'like', '%' . $request['query'] . '%')->where('instruction_english','!=',' ')->where('instruction_english','!=',null)->get();

        $lead_detail=Medium::where('medium_name', 'like', '%' . $request['query'] . '%')->get();
        

        if(count($lead_detail) > 0)
        {
            foreach ($lead_detail as $value) {
                $response[] = array("value"=>$value->medium_name,"data"=>$value->medium_name);
            }   
        }
        return json_encode(array("suggestions" => $response));
    }
    public function above_order(request $request)
    {
        above_order('mediums',$request->order_no);

        $mediums_details = Medium::where('status','Active')->orderBy('order_no','asc')->get();
        $html = view('medium.dynamic_table',compact('mediums_details'))->render();
        $data = ['html' => $html];
        return response()->json($data); 
    }
    public function below_order(request $request)
    {
        below_order('mediums',$request->order_no);
        $mediums_details = Medium::where('status','Active')->orderBy('order_no','asc')->get();
        $html = view('medium.dynamic_table',compact('mediums_details'))->render();
        $data = ['html' => $html];
        return response()->json($data); 
    }
}
