<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;
use App\Models\Board;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:view-feature', ['only' => ['index']]);
        $this->middleware('permission:add-feature', ['only' => ['create','store']]);
        $this->middleware('permission:edit-feature', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-feature', ['only' => ['distroy']]);
    }
    public function index()
    {
        $feature_details = Feature::where('status','Active')->get();
        return view('feature.index',compact('feature_details'));
    }

    /**

     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $boards = Board::where('status','Active')->get();
        return view('feature.add',compact('boards'));
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
            'title' => 'required',
            // 'image' => 'required'
        ]);

        $new_name='';
        if($request->has('image'))
        {
        
            $image = $request->file('image');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/feature/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }

        $add = new Feature;
        $add->title = $request->title;
        $add->image = $new_name;
        $add->feature_order = $request->order;
        $add->save();
        storeLog('feature',$add->id,date('Y-m-d H:i:s'),'create');
        storeReview('feature',$add->id,date('Y-m-d H:i:s'));
        return redirect()->route('feature.index')->with('success', 'Feature Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function show(Feature $feature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function edit(Feature $feature,$id)
    {
        $boards = Board::where('status','Active')->get();
        $featuredata = Feature::where('id',$id)->first();
        return view('feature.edit',compact('featuredata','boards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feature $feature,$id)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);

        $new_name='';
        if($request->has('image'))
        {
        
            $image = $request->file('image');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/feature/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }
        else{
            $new_name = $request->hidden_image;
        }

        $update = Feature::find($id);
        $update->title = $request->title;
        $update->image = $new_name;
        $update->feature_order = $request->order;
        $update->save();

        return redirect()->route('feature.index')->with('success', 'Feature Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function distroy(Feature $feature,$id)
    {
        $delete = Feature::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('feature.index')->with('success', 'Feature Deleted Successfully.');
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
