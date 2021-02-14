<?php

namespace App\Http\Controllers;

use App\Models\material;
use Illuminate\Http\Request;
use App\Models\unit;
use Auth;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $material_details = material::where('status','Active')->get();
        return view('material.index',compact('material_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = unit::where('status','Active')->get();
        return view('material.add',compact('units'));
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
            'size' => 'required',
            'label' => 'required', 
        ]);


        $add = new material;
        $add->user_id  = Auth::user()->id;
        $add->unit_id = $request->unit_id;
        $add->title = $request->title;
        $add->url = $request->url;
        $add->size = $request->size;
        $add->label = $request->label;
        $add->description = isset($request->description) ? $request->description:'';
        $add->save();

        return redirect()->route('material.index')->with('success', 'Material Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(material $material,$id)
    {
        $units = unit::where('status','Active')->get();
        $materialdata = material::where('id',$id)->first();
        return view('material.edit',compact('materialdata','units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, material $material,$id)
    {
        $this->validate($request, [
            'unit_id'     => 'required',
            'title' => 'required',
            'url' => 'required',
            'size' => 'required',
            'label' => 'required',
        ]);

        $update = material::find($id);
        $update->user_id  = Auth::user()->id;
        $update->unit_id = $request->unit_id;
        $update->title = $request->title;
        $update->url = $request->url;
        $update->size = $request->size;
        $update->label = $request->label;
        $update->description = isset($request->description) ? $request->description:'';
        $update->save();

        return redirect()->route('material.index')->with('success', 'Material Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\material  $material
     * @return \Illuminate\Http\Response
     */
    public function distroy(material $material,$id)
    {
        $delete = material::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('material.index')->with('success', 'Material Deleted Successfully.');
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
