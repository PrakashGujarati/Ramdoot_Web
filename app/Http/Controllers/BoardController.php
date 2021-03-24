<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view-board', ['only' => ['index']]);
        $this->middleware('permission:add-board', ['only' => ['create','store']]);
        $this->middleware('permission:edit-board', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-board', ['only' => ['distroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boards_details = Board::where('status','Active')->get();
        return view('board.index',compact('boards_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $boards_details = Board::where('status','Active')->get();
        return view('board.add',compact('boards_details'));
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
            'name'     => 'required',
            //'medium'  => 'required',
            'abbreviation' => 'required',
           // 'url'  => 'required',
            'thumbnail'  => 'required',
        ]);

        $new_name='';
        if($request->has('thumbnail'))
        {
        
            $image = $request->file('thumbnail');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/board/thumbnail/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }

        // $url_file='';
        // if($request->has('url'))
        // {
        //     $image = $request->file('url');
        //     $url_file = time().'.'.$image->getClientOriginalExtension();
        //     $destinationPath = public_path('upload/board/url/');
        //     $image->move($destinationPath, $url_file);
        // }

        $add = new Board;
        $add->name = $request->name;
        //$add->medium = $request->medium;
        $add->abbreviation = $request->abbreviation;
        //$add->url = $url_file;
        $add->thumbnail = $new_name;
        $add->save();

        $boards_details = Board::where('status','Active')->get();
        return view('board.dynamic_table',compact('boards_details'));
        //return redirect()->route('board.index')->with('success', 'Board Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function edit(Board $board,$id)
    {
        $boarddata = Board::where('id',$id)->first();
        return view('board.edit',compact('boarddata'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Board $board,$id)
    {
        $this->validate($request, [
            'name'     => 'required',
           // 'medium'  => 'required',
            'abbreviation' => 'required'
        ]);

        $new_name='';
        if($request->has('thumbnail'))
        {
        
            $image = $request->file('thumbnail');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/board/thumbnail/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }
        else{
            $new_name = $request->hidden_thumbnail;
        }


        // $url_file='';
        // if($request->has('url'))
        // {
        //     $image = $request->file('url');
        //     $url_file = time().'.'.$image->getClientOriginalExtension();
        //     $destinationPath = public_path('upload/board/url/');
        //     $image->move($destinationPath, $url_file);
        // }
        // else{
        //     $url_file = $request->hidden_url;
        // }

        

        $update = Board::find($id);
        $update->name = $request->name;
       // $update->medium = $request->medium;
        $update->abbreviation = $request->abbreviation;
        //$update->url = $url_file;
        $update->thumbnail = $new_name;
        $update->save();

        return redirect()->route('board.index')->with('success', 'Board Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function distroy(Board $board,$id)
    {
        $delete = Board::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('board.index')->with('success', 'Board Deleted Successfully.');
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
