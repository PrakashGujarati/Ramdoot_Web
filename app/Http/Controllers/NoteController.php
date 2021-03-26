<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Board;
use Auth;

class NoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-note', ['only' => ['index']]);
        $this->middleware('permission:add-note', ['only' => ['create','store']]);
        $this->middleware('permission:edit-note', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-note', ['only' => ['distroy']]);
    }
    public function index()
    {
        $note_details = Note::where('status','Active')->groupBy('subject_id')->get();
        return view('note.index',compact('note_details'));
    }

    public function create()
    {
    	$note_details = Note::where('status','Active')->get();
        $boards = Board::where('status','Active')->get();
        return view('note.add',compact('boards','note_details'));
    }


    public function store(Request $request)
    {

    	//dd($request->all());
        $this->validate($request, [
            'board_id' => 'required',
            'medium_id'  => 'required',
            'standard_id' => 'required',
            'semester_id'  => 'required',
            'subject_id' => 'required',
            'unit_id' => 'required',
            'title' => 'required',
            'sub_title' => 'required'
        ]);

        $new_name='';
        if($request->has('thumbnail'))
        {
        
            $image = $request->file('thumbnail');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('upload/note/thumbnail/');
            $image->move($destinationPath, $new_name);

            // $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            // $file_extension = strtolower($file_extension);

            // if(in_array($file_extension,$valid_ext)){
            //     $this->compressImage($image->getPathName(),$location,60);
            // }
        }

        $url_file='';
        if($request->url_type == 'file'){
            if($request->file('url'))
            {
                $image = $request->file('url');
                $url_file = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('upload/note/url/');
                $image->move($destinationPath, $url_file);
            }    
        }else{
            $url_file = $request->url;
        }
        

        $add = new Note;
        $add->user_id  = Auth::user()->id;
        $add->board_id = $request->board_id;
        $add->medium_id = $request->medium_id;
        $add->standard_id = $request->standard_id;
        $add->semester_id = $request->semester_id;
        $add->subject_id = $request->subject_id;
        $add->unit_id = $request->unit_id;
        $add->title = $request->title;
        $add->sub_title = $request->sub_title;
        $add->url_type = $request->url_type;
        $add->url = $url_file;
        $add->thumbnail = $new_name;
        $add->pages = isset($request->pages) ? $request->pages:'';
        $add->description = isset($request->description) ? $request->description:'';
        $add->label = $request->label;
        $add->release_date = $request->release_date;
        $add->edition = $request->edition;
        $add->save();

        $note_details = Note::where('status','Active')->get();
        
        // $html=view('note.dynamic_table',compact('note_details'))->render();
        return view('note.dynamic_table',compact('note_details'));
        // return response()->json(['success'=>true,'html'=>$html]);
    }

    public function edit($id)
    {
        $boards = Board::where('status','Active')->get();
        $mediumdata = Medium::where('id',$id)->first();

        return view('medium.edit',compact('boards','mediumdata'));
    }


    public function update(Request $request,$id)
    {

        $this->validate($request, [
            'board_id'     => 'required',
            'medium_name' => 'required',
        ]);

        $add = Medium::find($id);
        $add->board_id = $request->board_id;
        $add->medium_name = $request->medium_name;
        $add->save();

        return redirect()->route('medium.index')->with('success', 'Medium Updated Successfully.');
    }


    public function distroy($id)
    {
        $delete = Medium::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('medium.index')->with('success', 'Medium Deleted Successfully.');
    }    

}

