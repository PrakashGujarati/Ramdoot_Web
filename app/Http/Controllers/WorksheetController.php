<?php

namespace App\Http\Controllers;

use App\Models\Worksheet;
use Illuminate\Http\Request;
use App\Models\Unit;
use Auth;
use App\Models\Board;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\Standard;
use App\Models\Medium;

class WorksheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:Worksheet-view', ['only' => ['index']]);
        $this->middleware('permission:Worksheet-add', ['only' => ['create','store']]);
        $this->middleware('permission:Worksheet-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:Worksheet-delete', ['only' => ['distroy']]);
    }
    public function index()
    {
        $worksheet_details = Worksheet::where('status','!=','Deleted')->groupBy('semester_id')->get();
        return view('worksheet.index',compact('worksheet_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        if($id != null)
        {
            $units = Unit::where('status','!=','Deleted')->get();
            $boards = Board::where('status','!=','Deleted')->get();
            $worksheet_details = Worksheet::where(['semester_id' => $id])->where('status','!=','Deleted')->orderBy('order_no','asc')->get();
            $semesters_details = Semester::where('id',$id)->first();
            //$subjects_details = Subject::where('id',$id)->first();
            $isset = 1;
            return view('worksheet.add',compact('units','boards','worksheet_details','semesters_details','isset'));
        }
        else{
            $units = [];
            $boards = Board::where('status','!=','Deleted')->get();
            $worksheet_details = Worksheet::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
            $semesters_details = [];
            $isset = 0;
            return view('worksheet.add',compact('units','boards','worksheet_details','semesters_details','isset'));
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
            'unit_id'     => 'required',
            'board_id' => 'required',
            'medium_id'  => 'required',
            'standard_id' => 'required',
            'semester_id'  => 'required',
            'subject_id' => 'required',
            'title' => 'required',
        ]);

        if($request->hidden_id != "0")
        {
            $new_name='';
            if($request->thumbnail_file_type == 'Server'){
                if($request->has('thumbnail'))
                {
                
                    $image = $request->file('thumbnail');
                    $url = get_subtitle($request->unit_id).'/worksheet/thumbnail/';
                    $originalPath = imagePathCreate($url);
                    $name = time() . mt_rand(10000, 99999);
                    $new_name = $name . '.' . $image->getClientOriginalExtension();
                    $image->move($originalPath, $new_name);
                }
                else{
                    $new_name = $request->hidden_thumbnail;
                }
            }
            else{
                $new_name = $request->thumbnail;
            }

            $url_file='';
            if($request->url_type == 'Server'){
                if($request->file('url'))
                {
                    $image = $request->file('url');
                    $url = get_subtitle($request->unit_id).'/worksheet/url/';
                    $originalPath = imagePathCreate($url);
                    $name = time() . mt_rand(10000, 99999);
                    $url_file = $name . '.' . $image->getClientOriginalExtension();
                    $image->move($originalPath, $url_file);
                }
                else{
                    $url_file = $request->hidden_url;
                }    
            }else{
                $url_file = $request->url;
            }
            

            $add = Worksheet::find($request->hidden_id);
            $add->user_id  = Auth::user()->id;
            $add->unit_id = $request->unit_id;
            $add->board_id = $request->board_id;
            $add->medium_id = $request->medium_id;
            $add->standard_id = $request->standard_id;
            $add->semester_id = $request->semester_id;
            $add->subject_id = $request->subject_id;
            $add->title = $request->title;
            $add->sub_title = $request->sub_title;
            $add->url_type = $request->url_type;
            $add->url = $url_file;
            $add->label = $request->label;
            $add->thumbnail = $new_name;
            $add->thumbnail_file_type = $request->thumbnail_file_type;
            $add->description = isset($request->description) ? $request->description:'';
            $add->release_date = $request->release_date;
            $add->edition = $request->edition;
            $add->pages = isset($request->pages) ? $request->pages:'';
            $add->save();

            $msg = "Worksheet Updated Successfully.";
        }
        else{

            $new_name='';
            if($request->thumbnail_file_type == 'Server'){
                if($request->has('thumbnail'))
                {
                
                    $image = $request->file('thumbnail');
                    $url = get_subtitle($request->unit_id).'/worksheet/thumbnail/';
                    $originalPath = imagePathCreate($url);
                    $name = time() . mt_rand(10000, 99999);
                    $new_name = $name . '.' . $image->getClientOriginalExtension();
                    $image->move($originalPath, $new_name);
                }
            }
            else{
                $new_name = $request->thumbnail;
            }
            

            $url_file='';
            if($request->url_type == 'Server'){
                if($request->file('url'))
                {
                    $image = $request->file('url');
                    $url = get_subtitle($request->unit_id).'/worksheet/url/';
                    $originalPath = imagePathCreate($url);
                    $name = time() . mt_rand(10000, 99999);
                    $url_file = $name . '.' . $image->getClientOriginalExtension();
                    $image->move($originalPath, $url_file);
                }    
            }else{
                $url_file = $request->url;
            }

            $last_data=Worksheet::select('*')->where('semester_id',$request->semester_id)->orderBy('order_no','desc')->first();
              if($last_data)
              {
                $last_no=intval($last_data->order_no)+1;
              } 
              else
              {
                $last_no=1;
              }

            $add = new Worksheet;
            $add->user_id  = Auth::user()->id;
            $add->unit_id = $request->unit_id;
            $add->board_id = $request->board_id;
            $add->medium_id = $request->medium_id;
            $add->standard_id = $request->standard_id;
            $add->semester_id = $request->semester_id;
            $add->subject_id = $request->subject_id;
            $add->title = $request->title;
            $add->sub_title = $request->sub_title;
            $add->url_type = $request->url_type;
            $add->url = $url_file;
            $add->label = $request->label;
            $add->thumbnail = $new_name;
            $add->thumbnail_file_type = $request->thumbnail_file_type;
            $add->description = isset($request->description) ? $request->description:'';
            $add->release_date = $request->release_date;
            $add->edition = $request->edition;
            $add->pages = isset($request->pages) ? $request->pages:'';
            $add->order_no=$last_no;
            $add->save();

            $msg = "Worksheet Added Successfully.";

            storeLog('worksheet',$add->id,date('Y-m-d H:i:s'),'create');
            storeReview('worksheet',$add->id,date('Y-m-d H:i:s'));

        }

        $worksheet_details = Worksheet::where(['semester_id' => $request->semester_id])->where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        $html = view('worksheet.dynamic_table',compact('worksheet_details'))->render();
        $data = ['html' => $html,'message' => $msg];
        return response()->json($data);
        //return view('worksheet.dynamic_table',compact('worksheet_details'));
        //return redirect()->route('worksheet.index')->with('success', 'Worksheet Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\worksheet  $worksheet
     * @return \Illuminate\Http\Response
     */
    public function show(Worksheet $worksheet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\worksheet  $worksheet
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //$units = Unit::where('status','Active')->get();
        $worksheetdata = Worksheet::where('id',$request->id)->first();
        $board_sub_title = board::where(['id' => $worksheetdata->board_id])->first();
        $medium_sub_title = Medium::where(['id' => $worksheetdata->medium_id])->first();
        $standard_sub_title = Standard::where(['id' => $worksheetdata->standard_id])->first();
        $semester_sub_title = Semester::where(['id' => $worksheetdata->semester_id])->first();
        $subject_sub_title = Subject::where(['id' => $worksheetdata->subject_id])->first();
        $unit_sub_title = Unit::where(['id' => $worksheetdata->unit_id])->first();
        $sub_title = ['board_sub_title' => $board_sub_title,'medium_sub_title' => $medium_sub_title,
        'standard_sub_title' => $standard_sub_title,'semester_sub_title' => $semester_sub_title,
        'subject_sub_title' => $subject_sub_title,'unit_sub_title' => $unit_sub_title];
        $data = ['worksheetdata' => $worksheetdata,'sub_title' => $sub_title];
        return $data;

        //return $worksheetdata;

        //$boards = Board::where('status','Active')->get();
        //return view('worksheet.edit',compact('worksheetdata','units','boards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\worksheet  $worksheet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Worksheet $worksheet,$id)
    {
        $this->validate($request, [
            'unit_id'     => 'required',
            'board_id' => 'required',
            'medium_id'  => 'required',
            'standard_id' => 'required',
            'semester_id'  => 'required',
            'subject_id' => 'required',
            'title' => 'required'
        ]);

        $url_file='';
        if($request->has('url'))
        {
            $image = $request->file('url');
            $url_file = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('upload/worksheet/url/');
            $image->move($destinationPath, $url_file);
        }
        else{
            $url_file = $request->hidden_url;
        }

        $update = Worksheet::find($id);
        $update->user_id  = Auth::user()->id;
        $update->unit_id = $request->unit_id;
        $update->board_id = $request->board_id;
        $update->medium_id = $request->medium_id;
        $update->standard_id = $request->standard_id;
        $update->semester_id = $request->semester_id;
        $update->subject_id = $request->subject_id;
        $update->title = $request->title;
        $update->sub_title = $request->sub_title;
        $update->url = $url_file;
        $update->label = $request->label;
        $update->description = isset($request->description) ? $request->description:'';
        $update->save();

        return redirect()->route('worksheet.index')->with('success', 'Worksheet Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\worksheet  $worksheet
     * @return \Illuminate\Http\Response
     */
    public function distroy(Request $request)
    {
        if($request->has('status')){
          if($request->status == "Active"){
            $delete = Worksheet::find($request->id);
            $delete->status = "Inactive";
            $delete->save();
          }
          else{
            $delete = Worksheet::find($request->id);
            $delete->status = "Active";
            $delete->save();  
          }
        }else{
            $delete = Worksheet::find($request->id);
            $delete->status = "Deleted";
            $delete->save();

            delete_order('worksheets',$request->id,1);
        }

        $worksheet_details = Worksheet::where(['semester_id' => $request->semester_id])->where('status','!=','Deleted')->get();
        return view('worksheet.dynamic_table',compact('worksheet_details'));
        //return redirect()->route('worksheet.index')->with('success', 'Worksheet Deleted Successfully.');
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
    public function load_autocomplete(request $request)
    {
        $response=[];
        
        // $lead_detail=Medicine::where('instruction_english', 'like', '%' . $request['query'] . '%')->where('instruction_english','!=',' ')->where('instruction_english','!=',null)->get();

        $lead_detail=Worksheet::where('sub_title', 'like', '%' . $request['query'] . '%')->get();
        

        if(count($lead_detail) > 0)
        {
            foreach ($lead_detail as $value) {
                $response[] = array("value"=>$value->sub_title,"data"=>$value->sub_title);
            }   
        }
        return json_encode(array("suggestions" => $response));
    }
    public function load_autocomplete_title(request $request)
    {
        $response=[];
        
        // $lead_detail=Medicine::where('instruction_english', 'like', '%' . $request['query'] . '%')->where('instruction_english','!=',' ')->where('instruction_english','!=',null)->get();

        $lead_detail=Worksheet::where('title', 'like', '%' . $request['query'] . '%')->get();
        

        if(count($lead_detail) > 0)
        {
            foreach ($lead_detail as $value) {
                $response[] = array("value"=>$value->title,"data"=>$value->title);
            }   
        }
        return json_encode(array("suggestions" => $response));
    }
    public function above_order(request $request)
    {
        above_order('worksheets',$request->order_no,'semester_id',$request->semester_id);

        $worksheet_details = Worksheet::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        $html = view('worksheet.dynamic_table',compact('worksheet_details'))->render();
        $data = ['html' => $html];
        return response()->json($data);    
    }
    public function below_order(request $request)
    {
        below_order('worksheets',$request->order_no,'semester_id',$request->semester_id);

        $worksheet_details = Worksheet::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        $html = view('worksheet.dynamic_table',compact('worksheet_details'))->render();
        $data = ['html' => $html];
        return response()->json($data);    
    }    
}
