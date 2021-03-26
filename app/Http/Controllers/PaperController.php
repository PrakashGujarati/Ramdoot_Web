<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use Illuminate\Http\Request;
use App\Models\Unit;
use Auth;
use App\Models\Board;

class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:view-paper', ['only' => ['index']]);
        $this->middleware('permission:add-paper', ['only' => ['create','store']]);
        $this->middleware('permission:edit-paper', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-paper', ['only' => ['distroy']]);
    }
    public function index()
    {
        $paper_details = Paper::where('status','Active')->groupBy('subject_id')->get();
        return view('paper.index',compact('paper_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Unit::where('status','Active')->get();
        $boards = Board::where('status','Active')->get();
        $paper_details = Paper::where('status','Active')->get();
        return view('paper.add',compact('units','boards','paper_details'));
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

        $new_name='';
        if($request->has('thumbnail'))
        {
        
            $image = $request->file('thumbnail');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('upload/paper/thumbnail/');
            $image->move($destinationPath, $new_name);
        }

        $url_file='';

        if($request->has('url'))
        {
            $image = $request->file('url');
            $url_file = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('upload/paper/url/');
            $image->move($destinationPath, $url_file);
        }


        $add = new Paper;
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
        $add->pages = isset($request->pages) ? $request->pages:'';
        $add->label = $request->label;
        $add->description = isset($request->description) ? $request->description:'';
        $add->release_date = $request->release_date;
        $add->edition = $request->edition;
        $add->save();
        storeLog('paper',$add->id,date('Y-m-d H:i:s'),'create');
        storeReview('paper',$add->id,date('Y-m-d H:i:s'));

        $paper_details = Paper::where('status','Active')->get();
        return view('paper.dynamic_table',compact('paper_details'));
        //return redirect()->route('paper.index')->with('success', 'Paper Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function show(Paper $paper)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function edit(Paper $paper,$id)
    {
        $units = Unit::where('status','Active')->get();
        $paperdata = Paper::where('id',$id)->first();
        $boards = Board::where('status','Active')->get();
        return view('paper.edit',compact('paperdata','units','boards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paper $paper,$id)
    {
        $this->validate($request, [
            'unit_id'     => 'required',
            'board_id' => 'required',
            'medium_id'  => 'required',
            'standard_id' => 'required',
            'semester_id'  => 'required',
            'subject_id' => 'required',
            'title' => 'required',
            'label' => 'required',
        ]);

        $url_file='';
        
        if($request->has('url'))
        {
            $image = $request->file('url');
            $url_file = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('upload/paper/url/');
            $image->move($destinationPath, $url_file);
        }
        else{
            $url_file = $request->hidden_url;
        }

        $update = Paper::find($id);
        $update->user_id  = Auth::user()->id;
        $update->unit_id = $request->unit_id;
        $update->board_id = $request->board_id;
        $update->medium_id = $request->medium_id;
        $update->standard_id = $request->standard_id;
        $update->semester_id = $request->semester_id;
        $update->subject_id = $request->subject_id;
        $update->title = $request->title;
        $update->sub_title = $request->sub_title;
        $update->url_type = $request->url_type;
        $update->url = $url_file;
        $update->label = $request->label;
        $update->description = isset($request->description) ? $request->description:'';
        $update->save();

        return redirect()->route('paper.index')->with('success', 'Paper Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function distroy(Paper $paper,$id)
    {
        $delete = Paper::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('paper.index')->with('success', 'Paper Deleted Successfully.');
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

        $lead_detail=Paper::where('sub_title', 'like', '%' . $request['query'] . '%')->get();
        

        if(count($lead_detail) > 0)
        {
            foreach ($lead_detail as $value) {
                $response[] = array("value"=>$value->sub_title,"data"=>$value->sub_title);
            }   
        }
        return json_encode(array("suggestions" => $response));
    }
}
