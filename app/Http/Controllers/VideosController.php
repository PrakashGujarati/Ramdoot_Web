<?php

namespace App\Http\Controllers;

use App\Models\videos;
use Illuminate\Http\Request;
use App\Models\unit;
use Auth;
use App\Models\Board;

class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:view-video', ['only' => ['index']]);
        $this->middleware('permission:add-video', ['only' => ['create','store']]);
        $this->middleware('permission:edit-video', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-video', ['only' => ['distroy']]);
    }
    public function index()
    {
        $videos_details = videos::where('status','Active')->get();
        return view('videos.index',compact('videos_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = unit::where('status','Active')->get();
        $boards = Board::where('status','Active')->get();
        return view('videos.add',compact('units','boards'));
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
            'thumbnail'  => 'required',
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


        if($request->type == "File"){
            $url_file='';
            if($request->has('url_file'))
            {
                $image = $request->file('url_file');
                $url_file = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('upload/videos/url/');
                $image->move($destinationPath, $url_file);
            }    
        }
        else{
            $url_file = $request->url;
        }

        

        $add = new videos;
        $add->user_id  = Auth::user()->id;
        $add->unit_id = $request->unit_id;
        $add->board_id = $request->board_id;
        $add->medium_id = $request->medium_id;
        $add->standard_id = $request->standard_id;
        $add->semester_id = $request->semester_id;
        $add->subject_id = $request->subject_id;
        $add->title = $request->title;
        $add->type = $request->type;
        $add->url = $url_file;
        $add->thumbnail = $new_name;
        $add->duration = $request->duration;
        $add->description = isset($request->description) ? $request->description:'';
        $add->label = $request->label;
        $add->release_date = $request->release_date;
        $add->save();

        return redirect()->route('videos.index')->with('success', 'Videos Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\videos  $videos
     * @return \Illuminate\Http\Response
     */
    public function show(videos $videos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\videos  $videos
     * @return \Illuminate\Http\Response
     */
    public function edit(videos $videos,$id)
    {
        $units = unit::where('status','Active')->get();
        $videodata = videos::where('id',$id)->first();
        $boards = Board::where('status','Active')->get();
        return view('videos.edit',compact('videodata','units','boards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\videos  $videos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, videos $videos,$id)
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


        $update = videos::find($id);
        $update->unit_id = $request->unit_id;
        $update->board_id = $request->board_id;
        $update->medium_id = $request->medium_id;
        $update->standard_id = $request->standard_id;
        $update->semester_id = $request->semester_id;
        $update->subject_id = $request->subject_id;
        $update->title = $request->title;
        $update->type = $request->type;
        $update->url = $url_file;
        $update->thumbnail = $new_name;
        $update->duration = $request->duration;
        $update->description = isset($request->description) ? $request->description:'';
        $update->label = $request->label;
        $update->release_date = $request->release_date;
        $update->save();

        return redirect()->route('videos.index')->with('success', 'Videos Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\videos  $videos
     * @return \Illuminate\Http\Response
     */
    public function distroy(videos $videos,$id)
    {
        $delete = videos::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('videos.index')->with('success', 'Videos Deleted Successfully.');
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

}
