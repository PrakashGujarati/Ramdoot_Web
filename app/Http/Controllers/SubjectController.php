<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Standard;
use App\Models\Semester;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subject_details = Subject::where('status','Active')->get();
        return view('subject.index',compact('subject_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $boards = Board::where('status','Active')->get();
        $standards = Standard::where('status','Active')->get();
        $semesters = Semester::where('status','Active')->get();
        return view('subject.add',compact('boards','standards','semesters'));
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
            'board_id'     => 'required',
            'medium_id'  => 'required',
            'semester_id' => 'required',
            'standard_id'  => 'required',
            'subject_name' => 'required',
            'sub_title' => 'required',
            //'url' => 'required',
            'thumbnail'  => 'required',
        ]);

        $new_name='';
        if($request->has('thumbnail'))
        {
        
            $image = $request->file('thumbnail');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/subject/thumbnail/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if(in_array($file_extension,$valid_ext)){
                $this->compressImage($image->getPathName(),$location,60);
            }
        }

        //$url_file='';
        // if($request->has('url'))
        // {
        //     $image = $request->file('url');
        //     $url_file = time().'.'.$image->getClientOriginalExtension();
        //     $destinationPath = public_path('upload/subject/url/');
        //     $image->move($destinationPath, $url_file);
        // }

        $add = new Subject;
        $add->board_id = $request->board_id;
        $add->medium_id = $request->medium_id;
        $add->standard_id = $request->standard_id;
        $add->semester_id = $request->semester_id;
        $add->subject_name = $request->subject_name;
        $add->sub_title = $request->sub_title;
        //$add->url = $url_file;
        $add->thumbnail = $new_name;
        $add->save();

        return redirect()->route('subject.index')->with('success', 'Subject Added Successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject,$id)
    {
        $subjectdata = Subject::where('id',$id)->first();
        $boards = Board::where('status','Active')->get();
        $standards = Standard::where('status','Active')->get();
        $semesters = Semester::where('status','Active')->get();
        return view('subject.edit',compact('subjectdata','boards','standards','semesters'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject,$id)
    {
        $this->validate($request, [
            'board_id'     => 'required',
            'medium_id'  => 'required',
            'semester_id' => 'required',
            'standard_id'  => 'required',
            'subject_name' => 'required',
            'sub_title' => 'required',
        ]);

        $new_name='';
        if($request->has('thumbnail'))
        {
        
            $image = $request->file('thumbnail');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/subject/thumbnail/').$new_name;

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
        //     $destinationPath = public_path('upload/subject/url/');
        //     $image->move($destinationPath, $url_file);
        // }
        // else{
        //     $url_file = $request->hidden_url;
        // }

        $update = Subject::find($id);
        $update->board_id = $request->board_id;
        $update->medium_id = $request->medium_id;
        $update->standard_id = $request->standard_id;
        $update->semester_id = $request->semester_id;
        $update->subject_name = $request->subject_name;
        $update->sub_title = $request->sub_title;
        //$update->url = $url_file;
        $update->thumbnail = $new_name;
        $update->save();

        return redirect()->route('subject.index')->with('success', 'Subject Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function distroy(Subject $subject,$id)
    {
        $delete = Subject::find($id);
        $delete->status = "Deleted";
        $delete->save();

        return redirect()->route('subject.index')->with('success', 'Subject Deleted Successfully.');
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

    public function getSubject(Request $request){

        $getsubject = Subject::where(['board_id' => $request->board_id,'standard_id' => $request->standard_id,'medium_id' => $request->medium_id,'semester_id' => $request->semester_id,'status' => 'Active'])->get();

        $result="<option value=''>--Select Subject--</option>";
        if(count($getsubject) > 0)
        {
            foreach ($getsubject as $subject) {

                if($request->has('subject_id')){
                    if($request->subject_id == $subject->id){
                        $result.="<option value='".$subject->id."' selected>".$subject->subject_name."</option>";
                    }
                    else{
                        $result.="<option value='".$subject->id."'>".$subject->subject_name."</option>";    
                    }
                }else{
                    $result.="<option value='".$subject->id."'>".$subject->subject_name."</option>";
                }
            }
        }
        return response()->json(['html'=>$result]);   
    }
    
}
