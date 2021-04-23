<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:Board-view', ['only' => ['index']]);
        $this->middleware('permission:Board-add', ['only' => ['create','store']]);
        $this->middleware('permission:Board-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:Board-delete', ['only' => ['distroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boards_details = Board::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        return view('board.index',compact('boards_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $boards_details = Board::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
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
            'sub_title'  => 'required',
            'abbreviation' => 'required',
            'sub_title' => 'required|alpha'
           // 'url'  => 'required',
            //'thumbnail'  => 'required',
        ]);

        if($request->hidden_id != "0"){

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

            $update = Board::find($request->hidden_id);
            $update->name = $request->name;            
            $update->abbreviation = $request->abbreviation;
            $update->sub_title = $request->sub_title;
            $update->thumbnail = $new_name;
            $update->save();

            $msg = "Board Updated Successfully.";

        }else{

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
            $last_board=Board::select('*')->orderBy('order_no','asc')->first();
            if($last_board)
            {
              $last_number=intval($last_board->order_no)+1;
            } 
            else
            {
              $last_number=1;
            }
            $add = new Board;
            $add->name = $request->name;
            $add->abbreviation = $request->abbreviation;
            $add->sub_title = $request->sub_title;
            $add->thumbnail = $new_name;
            $add->order_no=$last_number;
            $add->save();
            
            storeLog('board',$add->id,date('Y-m-d H:i:s'),'create');

            storeReview('board',$add->id,date('Y-m-d H:i:s'));

            $msg = "Board Added Successfully.";


        }

        $boards_details = Board::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        $html = view('board.dynamic_table',compact('boards_details'))->render();
        $data = ['html' => $html,'message' => $msg];
        return response()->json($data);
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
    public function edit(Request $request)
    {
        $boarddata = Board::where('id',$request->id)->first();
        return $boarddata;
     //   return response()->json(['data'=> $boarddata]);
        //return view('board.edit',compact('boarddata'));
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
            'abbreviation' => 'required',
            'sub_title' => 'required|alpha'
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

        $update = Board::find($id);
        $update->name = $request->name;       
        $update->abbreviation = $request->abbreviation; 
        $update->sub_title = $update->sub_title;        
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
    public function distroy(Request $request)
    {
        if($request->has('status')){
          if($request->status == "Active"){
            $delete = Board::find($request->id);
            $delete->status = "Inactive";
            $delete->save();
          }
          else{
            $delete = Board::find($request->id);
            $delete->status = "Active";
            $delete->save();  
          }
        }else{
            $delete = Board::find($request->id);
            $delete->status = "Deleted";
            $delete->save();

            delete_order('boards',$request->id);
        }

        $boards_details = Board::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        return view('board.dynamic_table',compact('boards_details'));

        //return redirect()->route('board.index')->with('success', 'Board Deleted Successfully.');
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
    public function above_order_board(request $request)
    {
        above_order('boards',$request->order_no);

        $boards_details = Board::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        $html = view('board.dynamic_table',compact('boards_details'))->render();
        $data = ['html' => $html];
        return response()->json($data);
    }
    public function below_order_board(request $request)
    {
        below_order('boards',$request->order_no);
        $boards_details = Board::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        $html = view('board.dynamic_table',compact('boards_details'))->render();
        $data = ['html' => $html];
        return response()->json($data); 
    }
}
