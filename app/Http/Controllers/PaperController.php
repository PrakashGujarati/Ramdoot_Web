<?php

namespace App\Http\Controllers;

use App\Models\paper;
use Illuminate\Http\Request;
use App\Models\unit;
use Auth;

class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paper_details = paper::where('status','Active')->get();
        return view('paper.index',compact('paper_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = unit::where('status','Active')->get();
        return view('paper.add',compact('units'));
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
            'title' => 'required',
            'url' => 'required',
            'label' => 'required', 
        ]);

        $url_file='';
        if($request->has('url'))
        {
            $image = $request->file('url');

            $url_file = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/paper/url/').$url_file;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }


        $add = new paper;
        $add->user_id  = Auth::user()->id;
        $add->unit_id = $request->unit_id;
        $add->title = $request->title;
        $add->url = $url_file;
        $add->label = $request->label;
        $add->description = isset($request->description) ? $request->description:'';
        $add->save();

        return redirect()->route('paper.index')->with('success', 'Paper Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function show(paper $paper)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function edit(paper $paper,$id)
    {
        $units = unit::where('status','Active')->get();
        $paperdata = paper::where('id',$id)->first();
        return view('paper.edit',compact('paperdata','units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, paper $paper,$id)
    {
        $this->validate($request, [
            'unit_id'     => 'required',
            'title' => 'required',
            'label' => 'required',
        ]);

        $url_file='';
        if($request->has('url'))
        {

            $image = $request->file('url');

            $url_file = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/paper/url/').$url_file;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }
        else{
            $url_file = $request->hidden_url;
        }

        $update = paper::find($id);
        $update->user_id  = Auth::user()->id;
        $update->unit_id = $request->unit_id;
        $update->title = $request->title;
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
    public function distroy(paper $paper,$id)
    {
        $delete = paper::find($id);
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
}
