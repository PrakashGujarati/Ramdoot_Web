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


        $add = new paper;
        $add->user_id  = Auth::user()->id;
        $add->unit_id = $request->unit_id;
        $add->title = $request->title;
        $add->url = $request->url;
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
            'url' => 'required',
            'label' => 'required',
        ]);

        $update = paper::find($id);
        $update->user_id  = Auth::user()->id;
        $update->unit_id = $request->unit_id;
        $update->title = $request->title;
        $update->url = $request->url;
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
