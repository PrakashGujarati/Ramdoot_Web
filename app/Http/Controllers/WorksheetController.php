<?php

namespace App\Http\Controllers;

use App\Models\Worksheet;
use Illuminate\Http\Request;
use App\Models\Unit;
use Auth;
use App\Models\Board;

class WorksheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $worksheet_details = Worksheet::where('status','Active')->get();
        return view('worksheet.index',compact('worksheet_details'));
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
        $worksheet_details = Worksheet::where('status','Active')->get();
        return view('worksheet.add',compact('units','boards','worksheet_details'));
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
            'url' => 'required',
            'type' => 'required',
            'label' => 'required', 
        ]);

        $url_file='';
        if($request->has('url'))
        {
            $image = $request->file('url');
            $url_file = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('upload/worksheet/url/');
            $image->move($destinationPath, $url_file);
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
        $add->url = $url_file;
        $add->type = $request->type;
        $add->label = $request->label;
        $add->description = isset($request->description) ? $request->description:'';
        $add->save();


        $worksheet_details = Worksheet::where('status','Active')->get();
        return view('worksheet.dynamic_table',compact('worksheet_details'));
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
    public function edit(worksheet $worksheet,$id)
    {
        $units = Unit::where('status','Active')->get();
        $worksheetdata = Worksheet::where('id',$id)->first();
        $boards = Board::where('status','Active')->get();
        return view('worksheet.edit',compact('worksheetdata','units','boards'));
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
            'title' => 'required',
            'type' => 'required',
            'label' => 'required',
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
        $update->url = $url_file;
        $update->type = $request->type;
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
    public function distroy(Worksheet $worksheet,$id)
    {
        $delete = Worksheet::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('worksheet.index')->with('success', 'Worksheet Deleted Successfully.');
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
