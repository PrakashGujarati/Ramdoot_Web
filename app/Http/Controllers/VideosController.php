<?php

namespace App\Http\Controllers;

use App\Models\Videos;
use Illuminate\Http\Request;
use App\Models\Unit;
use Auth;
use App\Models\Board;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\Medium;
use App\Models\Standard;

class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:Video-view', ['only' => ['index']]);
        $this->middleware('permission:Video-add', ['only' => ['create','store']]);
        $this->middleware('permission:Video-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:Video-delete', ['only' => ['distroy']]);
    }
    public function index()
    {
        $videos_details = Videos::where('status','!=','Deleted')->groupBy('subject_id')->get();
        return view('videos.index',compact('videos_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        if($id != null){
            $units = Unit::where('status','!=','Deleted')->get();
            $boards = Board::where('status','!=','Deleted')->get();
            $videos_details = Videos::where(['semester_id' => $id])->where('status','!=','Deleted')->orderBy('order_no','asc')->get();
            //$subjects_details = Subject::where('id',$id)->first();
            $semesters_details = Semester::where('id',$id)->first();
            $isset = 1;
            return view('videos.add',compact('units','boards','videos_details','semesters_details','isset'));
        }
        else{
            $boards = Board::where('status','!=','Deleted')->get();
            $units = [];
            $videos_details = Videos::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
            //$subjects_details=[];
            $semesters_details = [];
            $isset = 0;
            return view('videos.add',compact('units','boards','videos_details','semesters_details','isset'));
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
            // 'thumbnail'  => 'required',
            // 'duration' => 'required',
            // 'label' => 'required',
            // 'release_date' => 'required',    
        ]);


        if($request->hidden_id != "0")
        {

            $new_name='';
            if($request->thumbnail_file_type == 'Server'){
                if($request->has('thumbnail'))
                {
                
                    $image = $request->file('thumbnail');

                    $url = get_subtitle($request->unit_id).'/videos/thumbnail/';
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


            if($request->url_type == "Server"){
                $url_file='';
                if($request->has('url'))
                {
                    $image = $request->file('url');

                    $url = get_subtitle($request->unit_id).'/videos/url/';
                    $originalPath = imagePathCreate($url);
                    $name = time() . mt_rand(10000, 99999);
                    $url_file = $name . '.' . $image->getClientOriginalExtension();
                    $image->move($originalPath, $url_file);
                }    
                else{
                    $url_file = $request->hidden_url;
                }
            }
            else{
                $url_file = $request->url;
            }


            $add = Videos::find($request->hidden_id);
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
            $add->thumbnail = $new_name;
            $add->thumbnail_file_type = $request->thumbnail_file_type;
            $add->duration = $request->duration;
            $add->description = isset($request->description) ? $request->description:'';
            $add->label = $request->label;
            $add->release_date = $request->release_date;
            $add->edition = $request->edition;
            $add->start_time = $request->start_time;
            $add->save();
            
            $msg = "Video Updated Successfully.";
        }
        else{

            $new_name='';
            if($request->thumbnail_file_type == 'Server'){
                if($request->has('thumbnail'))
                {
                
                    $image = $request->file('thumbnail');
                    $url = get_subtitle($request->unit_id).'/videos/thumbnail/';
                    $originalPath = imagePathCreate($url);
                    $name = time() . mt_rand(10000, 99999);
                    $new_name = $name . '.' . $image->getClientOriginalExtension();
                    $image->move($originalPath, $new_name);
                }
            }
            else{
                $new_name = $request->thumbnail;
            }


            if($request->url_type == "Server"){
                $url_file='';
                if($request->has('url'))
                {
                    $image = $request->file('url');
                    $url = get_subtitle($request->unit_id).'/videos/url/';
                    $originalPath = imagePathCreate($url);
                    $name = time() . mt_rand(10000, 99999);
                    $url_file = $name . '.' . $image->getClientOriginalExtension();
                    $image->move($originalPath, $url_file);
                }    
            }
            else{
                $url_file = $request->url;
            }

            $last_data=Videos::select('*')->where('semester_id',$request->semester_id)->orderBy('order_no','desc')->first();
            if($last_data)
            {
              $last_no=intval($last_data->order_no)+1;
            } 
            else
            {
              $last_no=1;
            }

            $add = new Videos;
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
            $add->thumbnail = $new_name;
            $add->thumbnail_file_type = $request->thumbnail_file_type;
            $add->duration = $request->duration;
            $add->description = isset($request->description) ? $request->description:'';
            $add->label = $request->label;
            $add->release_date = $request->release_date;
            $add->edition = $request->edition;
            $add->order_no=$last_no;
            $add->start_time = $request->start_time;
            $add->save();

            $msg = "Video Added Successfully.";

            storeLog('video',$add->id,date('Y-m-d H:i:s'),'create');
            storeReview('video',$add->id,date('Y-m-d H:i:s'));

        }

        $videos_details = Videos::where(['semester_id' => $request->semester_id])->where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        $html = view('videos.dynamic_table',compact('videos_details'))->render();
        $data = ['html' => $html,'message' => $msg];
        return response()->json($data);
        
        //return view('videos.dynamic_table',compact('videos_details'));
        //return redirect()->route('videos.index')->with('success', 'Videos Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\videos  $videos
     * @return \Illuminate\Http\Response
     */
    public function show(Videos $videos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\videos  $videos
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
       // $units = Unit::where('status','Active')->get();
        $videodata = videos::where('id',$request->id)->first();
        $board_sub_title = board::where(['id' => $videodata->board_id])->first();
        $medium_sub_title = Medium::where(['id' => $videodata->medium_id])->first();
        $standard_sub_title = Standard::where(['id' => $videodata->standard_id])->first();
        $semester_sub_title = Semester::where(['id' => $videodata->semester_id])->first();
        $subject_sub_title = Subject::where(['id' => $videodata->subject_id])->first();
        $unit_sub_title = Unit::where(['id' => $videodata->unit_id])->first();
        $sub_title = ['board_sub_title' => $board_sub_title,'medium_sub_title' => $medium_sub_title,
        'standard_sub_title' => $standard_sub_title,'semester_sub_title' => $semester_sub_title,
        'subject_sub_title' => $subject_sub_title,'unit_sub_title' => $unit_sub_title];
        $data = ['videodetails' => $videodata,'sub_title' => $sub_title];
        return $data;
        //return $videodata;
      //  $boards = Board::where('status','Active')->get();
        //return view('videos.edit',compact('videodata','units','boards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\videos  $videos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Videos $videos,$id)
    {
        $this->validate($request, [
            'unit_id' => 'required',
            'board_id' => 'required',
            'medium_id'  => 'required',
            'standard_id' => 'required',
            'semester_id'  => 'required',
            'subject_id' => 'required',
            'title' => 'required',
            'duration' => 'required',
            'label' => 'required',
            'release_date' => 'required',
        ]);

        $new_name='';
        if($request->has('thumbnail'))
        {
        
            $image = $request->file('thumbnail');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/videos/thumbnail/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }
        else{
            $new_name = $request->hidden_thumbnail;
        }


        if($request->type == "File"){
            $url_file='';
            if($request->has('url_file'))
            {
                $image = $request->file('url_file');
                $url_file = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('upload/videos/url/');
                $image->move($destinationPath, $url_file);
            }
            else{
                $url_file = $request->hidden_url;
            }    
        }
        else{
            $url_file = $request->url;
        }


        $update = Videos::find($id);
        $update->unit_id = $request->unit_id;
        $update->board_id = $request->board_id;
        $update->medium_id = $request->medium_id;
        $update->standard_id = $request->standard_id;
        $update->semester_id = $request->semester_id;
        $update->subject_id = $request->subject_id;
        $update->title = $request->title;
        $update->sub_title = $require->sub_title;
        $update->url_type = $request->url_type;
        $update->thumbnail = $new_name;
        $update->duration = $request->duration;
        $update->description = isset($request->description) ? $request->description:'';
        $update->label = $request->label;
        $update->release_date = $request->release_date;
        $update->edition = $request->edition;
        $update->save();

        return redirect()->route('videos.index')->with('success', 'Videos Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\videos  $videos
     * @return \Illuminate\Http\Response
     */
    public function distroy(Request $request)
    {
        if($request->has('status')){
          if($request->status == "Active"){
            $delete = Videos::find($request->id);
            $delete->status = "Inactive";
            $delete->save();
          }
          else{
            $delete = Videos::find($request->id);
            $delete->status = "Active";
            $delete->save();  
          }
        }else{
            $delete = Videos::find($request->id);
            $delete->status = "Deleted";
            $delete->save();

            delete_order('videos',$request->id,1);
        }

        $videos_details = Videos::where(['semester_id' => $request->semester_id])->where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        return view('videos.dynamic_table',compact('videos_details'));
        //return redirect()->route('videos.index')->with('success', 'Videos Deleted Successfully.');
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

        $lead_detail=Videos::where('title', 'like', '%' . $request['query'] . '%')->get();
        

        if(count($lead_detail) > 0)
        {
            foreach ($lead_detail as $value) {
                $response[] = array("value"=>$value->title,"data"=>$value->title);
            }   
        }
        return json_encode(array("suggestions" => $response));
    }
    public function load_autocomplete_sub_title(request $request)
    {
        $response=[];
        
        // $lead_detail=Medicine::where('instruction_english', 'like', '%' . $request['query'] . '%')->where('instruction_english','!=',' ')->where('instruction_english','!=',null)->get();

        $lead_detail=Videos::where('sub_title', 'like', '%' . $request['query'] . '%')->get();
        

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
        above_order('videos',$request->order_no,'semester_id',$request->semester_id);

        $videos_details = Videos::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        $html = view('videos.dynamic_table',compact('videos_details'))->render();
        $data = ['html' => $html];
        return response()->json($data);    
    }
    public function below_order(request $request)
    {
        below_order('videos',$request->order_no,'semester_id',$request->semester_id);

        $videos_details = Videos::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        $html = view('videos.dynamic_table',compact('videos_details'))->render();
        $data = ['html' => $html];
        return response()->json($data);    
    }
    
}

