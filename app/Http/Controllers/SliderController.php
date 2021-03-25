<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:view-slider', ['only' => ['index']]);
        $this->middleware('permission:add-slider', ['only' => ['create','store']]);
        $this->middleware('permission:edit-slider', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-slider', ['only' => ['distroy']]);
    }
    public function index()
    {
        $slider_details = Slider::where('status','Active')->get();
        return view('slider.index',compact('slider_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('slider.add');
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
            'area' => 'required',
            'image' => 'required',
            'url' => 'required',
            'text' => 'required',
            'order' => 'required',
        ]);

        $new_name='';
        if($request->has('image'))
        {
        
            $image = $request->file('image');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/slider/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }

        $add = new Slider;
        $add->area = $request->area;
        $add->url = $request->url;
        $add->text = $request->text;
        $add->order = $request->order;
        $add->image = $new_name;
        $add->save();

        return redirect()->route('slider.index')->with('success', 'Slide Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider,$id)
    {
        $sliderdata = Slider::where('id',$id)->first();
        return view('slider.edit',compact('sliderdata'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider,$id)
    {
        $this->validate($request, [
            'area' => 'required',
            'url' => 'required',
            'text' => 'required',
            'order' => 'required',
        ]);

        $new_name='';
        if($request->has('image'))
        {
        
            $image = $request->file('image');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/slider/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }
        else{
            $new_name = $request->hidden_image;
        }

        $update = Slider::find($id);
        $update->area = $request->area;
        $update->url = $request->url;
        $update->text = $request->text;
        $update->order = $request->order;
        $update->image = $new_name;
        $update->save();

        return redirect()->route('slider.index')->with('success', 'Slider Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function distroy(Slider $slider,$id)
    {
        $delete = Slider::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('slider.index')->with('success', 'Slide Deleted Successfully.');
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
