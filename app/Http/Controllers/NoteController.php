<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Board;
use Auth;
use App\Models\Subject;
use App\Models\Semester;

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
        $note_details = Note::where('status','!=','Deleted')->groupBy('subject_id')->get();
        return view('note.index',compact('note_details'));
    }

    public function create($id=null)
    {
        if($id != null){
            $note_details = Note::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
            $boards = Board::where('status','!=','Deleted')->get();
            $subjects_details = Subject::where('id',$id)->first();
            $isset = 1;
            return view('note.add',compact('boards','note_details','subjects_details','isset'));
        }
        else{
            $boards = Board::where('status','!=','Deleted')->get();
            $note_details = Note::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
            $subjects_details=[];
            $isset = 0;
            return view('note.add',compact('boards','note_details','subjects_details','isset'));
        }
    	
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

        if($request->hidden_id != "0")
        {   

            $new_name='';
            if($request->has('thumbnail'))
            {
            
                $image = $request->file('thumbnail');
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('upload/note/thumbnail/');
                $image->move($destinationPath, $new_name);
            }
            else{
                $new_name = $request->hidden_thumbnail;
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
                else{
                    $url_file = $request->hidden_url;
                }    
            }else{
                $url_file = $request->url;
            }
            

            $add = Note::find($request->hidden_id);
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

            $msg = "Note Updated Successfully.";

        }
        else{

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
                
            $last_data=Semester::select('*')->where('subject_id',$request->subject_id)->orderBy('order_no','desc')->first();
            if($last_data)
            {
              $last_no=intval($last_data->order_no)+1;
            } 
            else
            {
              $last_no=1;
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
            $add->order_no= isset($last_no) ? $last_no:0;
            $add->save();

            storeLog('note',$add->id,date('Y-m-d H:i:s'),'create');
            storeReview('note',$add->id,date('Y-m-d H:i:s'));

            $msg = "Note Added Successfully.";
        }

        $note_details = Note::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        $html = view('note.dynamic_table',compact('note_details'))->render();
        $data = ['html' => $html,'message' => $msg];
        return response()->json($data);
        // $html=view('note.dynamic_table',compact('note_details'))->render();
        //return view('note.dynamic_table',compact('note_details'));
        // return response()->json(['success'=>true,'html'=>$html]);
    }

    public function edit(Request $request)
    {
        //$boards = Board::where('status','Active')->get();
        $notedata = Note::where('id',$request->id)->first();
        return $notedata;
        //return view('medium.edit',compact('boards','mediumdata'));
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


    public function distroy(Request $request)
    {
        if($request->has('status')){
          if($request->status == "Active"){
            $delete = Note::find($request->id);
            $delete->status = "Inactive";
            $delete->save();
          }
          else{
            $delete = Note::find($request->id);
            $delete->status = "Active";
            $delete->save();  
          }
        }else{
            $delete = Note::find($request->id);
            $delete->status = "Deleted";
            $delete->save();
            delete_order('notes',$request->id,1);
        }

        $note_details = Note::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        return view('note.dynamic_table',compact('note_details'));  
        //return redirect()->route('medium.index')->with('success', 'Medium Deleted Successfully.');
    }    
    public function load_autocomplete(request $request)
    {
        $response=[];
        
        // $lead_detail=Medicine::where('instruction_english', 'like', '%' . $request['query'] . '%')->where('instruction_english','!=',' ')->where('instruction_english','!=',null)->get();

        $lead_detail=Note::where('sub_title', 'like', '%' . $request['query'] . '%')->get();
        

        if(count($lead_detail) > 0)
        {
            foreach ($lead_detail as $value) {
                $response[] = array("value"=>$value->sub_title,"data"=>$value->sub_title);
            }   
        }
        return json_encode(array("suggestions" => $response));
    }

    public function load_autocomplete_title(request $request)
    {
        //dd('asd');die;
        $response=[];
        
        // $lead_detail=Medicine::where('instruction_english', 'like', '%' . $request['query'] . '%')->where('instruction_english','!=',' ')->where('instruction_english','!=',null)->get();

        $lead_detail=Note::where('title', 'like', '%' . $request['query'] . '%')->get();
        

        if(count($lead_detail) > 0)
        {
            foreach ($lead_detail as $value) {
                $response[] = array("value"=>$value->title,"data"=>$value->title);
            }   
        }
        return json_encode(array("suggestions" => $response));
    }
    public function above_order(request $request)
    {
        above_order('notes',$request->order_no,'subject_id',$request->subject_id);

        $note_details = Note::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        $html = view('note.dynamic_table',compact('note_details'))->render();
        $data = ['html' => $html];
        return response()->json($data);    
    }
    public function below_order(request $request)
    {
        below_order('notes',$request->order_no,'subject_id',$request->subject_id);

        $note_details = Note::where('status','!=','Deleted')->orderBy('order_no','asc')->get();
        $html = view('note.dynamic_table',compact('note_details'))->render();
        $data = ['html' => $html];
        return response()->json($data);    
    }
    
}

