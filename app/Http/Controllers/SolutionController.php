<?php

namespace App\Http\Controllers;

use App\Models\Solution;
use Illuminate\Http\Request;
use App\Models\Unit;
use Auth;
use App\Models\Board;
use App\Models\QuestionType;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\Medium;
use App\Models\Standard;
use App\Models\Media;

class SolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:Solution-view', ['only' => ['index']]);
        $this->middleware('permission:Solution-add', ['only' => ['create','store']]);
        $this->middleware('permission:Solution-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:Solution-delete', ['only' => ['distroy']]);
    }
    public function index()
    {
        $solution_details = Solution::where('status', '!=', 'Deleted')->groupBy('semester_id')->get();
        return view('solution.index', compact('solution_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        if ($id != null) {
            $units = Unit::where('status', '!=', 'Deleted')->get();
            $boards = Board::where('status', '!=', 'Deleted')->get();
            $solution_details = Solution::where(['semester_id' => $id])->where('status', '!=', 'Deleted')->orderBy('order_no', 'asc')->get();
            $question_type_details = QuestionType::where('status', '!=', 'Deleted')->get();
            $isset = 1;

            $subjects_details=null;
            if ($id != null) {
                $semesters_details = Semester::where('id', $id)->first();
                //$subjects_details = Subject::where('id',$id)->first();
            }

            return view('solution.add', compact('units', 'boards', 'solution_details', 'question_type_details', 'semesters_details', 'id', 'isset'));
        } else {
            $boards = Board::where('status', '!=', 'Deleted')->get();
            $units = [];
            $solution_details = Solution::where('status', '!=', 'Deleted')->orderBy('order_no', 'asc')->get();
            $semesters_details = [];
            $question_type_details = QuestionType::where('status', '!=', 'Deleted')->get();
            $isset = 0;

            $subjects_details=null;
            if ($id != null) {
                $subjects_details = Subject::where('id', $id)->first();
            }

            return view('solution.add', compact(
                'units',
                'boards',
                'solution_details',
                'question_type_details',
                'semesters_details',
                'id',
                'isset'
            ));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'unit_id'     => 'required',
            'board_id' => 'required',
            'medium_id'  => 'required',
            'standard_id' => 'required',
            'semester_id'  => 'required',
            'subject_id' => 'required',
            // 'question' => 'required',
            // 'answer' => 'required',
            // 'marks' => 'required',
            // 'image'  => 'required',
            // 'label' => 'required'
        ]);

        if ($request->hidden_id != "0") {
            $new_name='';
            if ($request->image_file_type == 'Server') {
                if ($request->has('image')) {
                    $image = $request->file('image');
                    $url = get_subtitle($request->unit_id).'/solution/thumbnail/';
                    $originalPath = imagePathCreate($url);
                    $name = time() . mt_rand(10000, 99999);
                    $new_name = $name . '.' . $image->getClientOriginalExtension();
                    $image->move($originalPath, $new_name);
                } else {
                    $new_name = $request->hidden_image;
                }
            } else {
                $new_name = $request->image;
            }


            $add = Solution::find($request->hidden_id);
            $add->user_id  = Auth::user()->id;
            $add->unit_id = $request->unit_id;
            $add->board_id = $request->board_id;
            $add->medium_id = $request->medium_id;
            $add->standard_id = $request->standard_id;
            $add->semester_id = $request->semester_id;
            $add->subject_id = $request->subject_id;
            $add->question = $request->question;
            $add->answer = $request->answer;
            $add->image = $new_name;
            $add->image_file_type = $request->image_file_type;
            $add->marks = $request->marks;
            $add->label = $request->label;
            $add->question_type = $request->question_type;
            $add->level = $request->level;
            $add->save();

            $msg = "Solution Updated Successfully.";
        } else {
            $new_name='';
            if ($request->image_file_type == 'Server') {
                if ($request->has('image')) {
                    $image = $request->file('image');
                    $url = get_subtitle($request->unit_id).'/solution/thumbnail/';
                    $originalPath = imagePathCreate($url);
                    $name = time() . mt_rand(10000, 99999);
                    $new_name = $name . '.' . $image->getClientOriginalExtension();
                    $image->move($originalPath, $new_name);
                }
            } else {
                $new_name = $request->image;
            }

            $last_data=Solution::select('*')->where('semester_id', $request->semester_id)->orderBy('order_no', 'desc')->first();
            if ($last_data) {
                $last_no=intval($last_data->order_no)+1;
            } else {
                $last_no=1;
            }

            $add = new Solution;
            $add->user_id  = Auth::user()->id;
            $add->unit_id = $request->unit_id;
            $add->board_id = $request->board_id;
            $add->medium_id = $request->medium_id;
            $add->standard_id = $request->standard_id;
            $add->semester_id = $request->semester_id;
            $add->subject_id = $request->subject_id;
            $add->question = $request->question;
            $add->answer = $request->answer;
            $add->image = $new_name;
            $add->image_file_type = $request->image_file_type;
            $add->marks = $request->marks;
            $add->label = $request->label;
            $add->question_type = $request->question_type;
            $add->level = $request->level;
            $add->order_no=$last_no;
            $add->save();

            $msg = "Solution Added Successfully.";

            storeLog('solution', $add->id, date('Y-m-d H:i:s'), 'create');
            storeReview('solution', $add->id, date('Y-m-d H:i:s'));
        }

        $solution_details = Solution::where(['semester_id' => $request->semester_id])->where('status', '!=', 'Deleted')->orderBy('order_no', 'asc')->get();
        $html = view('solution.dynamic_table', compact('solution_details'))->render();
        $data = ['html' => $html,'message' => $msg];
        return response()->json($data);


        //return view('solution.dynamic_table',compact('solution_details'));
        //return redirect()->route('solution.index')->with('success', 'Solution Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\solution  $solution
     * @return \Illuminate\Http\Response
     */
    public function show(Solution $solution)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\solution  $solution
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        // $units = Unit::where('status','Active')->get();
        $solutiondata = Solution::where('id', $request->id)->first();
        $board_sub_title = board::where(['id' => $solutiondata->board_id])->first();
        $medium_sub_title = Medium::where(['id' => $solutiondata->medium_id])->first();
        $standard_sub_title = Standard::where(['id' => $solutiondata->standard_id])->first();
        $semester_sub_title = Semester::where(['id' => $solutiondata->semester_id])->first();
        $subject_sub_title = Subject::where(['id' => $solutiondata->subject_id])->first();
        $unit_sub_title = Unit::where(['id' => $solutiondata->unit_id])->first();
        $sub_title = ['board_sub_title' => $board_sub_title,'medium_sub_title' => $medium_sub_title,
        'standard_sub_title' => $standard_sub_title,'semester_sub_title' => $semester_sub_title,
        'subject_sub_title' => $subject_sub_title,'unit_sub_title' => $unit_sub_title];
        $data = ['solutiondata' => $solutiondata,'sub_title' => $sub_title];
        return $data;
        // $boards = Board::where('status','Active')->get();
        //$question_type_details = QuestionType::where('status','Active')->get();
        //return view('solution.edit',compact('solutiondata','units','boards','question_type_details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\solution  $solution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Solution $solution, $id)
    {
        $this->validate($request, [
            'unit_id'     => 'required',
            'board_id' => 'required',
            'medium_id'  => 'required',
            'standard_id' => 'required',
            'semester_id'  => 'required',
            'subject_id' => 'required',
            'question' => 'required',
            'answer' => 'required',
            'marks' => 'required',
            'label' => 'required',
        ]);

        $new_name='';
        if ($request->has('image')) {
            $image = $request->file('image');

            $new_name = rand() . '.' . $image->getClientOriginalExtension();

            $valid_ext = array('png','jpeg','jpg');

            // Location
            $location = public_path('upload/solution/thumbnail/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if (in_array($file_extension, $valid_ext)) {
                $this->compressImage($image->getPathName(), $location, 60);
            }
        } else {
            $new_name = $request->hidden_image;
        }

        $update = Solution::find($id);
        $update->user_id  = Auth::user()->id;
        $update->unit_id = $request->unit_id;
        $update->board_id = $request->board_id;
        $update->medium_id = $request->medium_id;
        $update->standard_id = $request->standard_id;
        $update->semester_id = $request->semester_id;
        $update->subject_id = $request->subject_id;
        $update->question = $request->question;
        $update->answer = $request->answer;
        $update->image = $new_name;
        $update->marks = $request->marks;
        $update->label = $request->label;
        $update->question_type = $request->question_type;
        $update->level = $request->level;
        $update->save();

        return redirect()->route('solution.index')->with('success', 'Solution Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\solution  $solution
     * @return \Illuminate\Http\Response
     */
    public function distroy(Request $request)
    {
        if ($request->has('status')) {
            if ($request->status == "Active") {
                $delete = Solution::find($request->id);
                $delete->status = "Inactive";
                $delete->save();
            } else {
                $delete = Solution::find($request->id);
                $delete->status = "Active";
                $delete->save();
            }
        } else {
            $delete = Solution::find($request->id);
            $delete->status = "Deleted";
            $delete->save();

            delete_order('solutions', $request->id, 1);
        }

        $solution_details = Solution::where(['semester_id' => $request->semester_id])->where('status', '!=', 'Deleted')->orderBy('order_no', 'asc')->get();
        return view('solution.dynamic_table', compact('solution_details'));
        //return redirect()->route('solution.index')->with('success', 'Solution Deleted Successfully.');
    }

    public function compressImage($source, $destination, $quality)
    {
        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($source);
        } elseif ($info['mime'] == 'image/gif') {
            $image = imagecreatefromgif($source);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source);
        }

        imagejpeg($image, $destination, $quality);
    }
    public function above_order(request $request)
    {
        above_order('solutions', $request->order_no, 'semester_id', $request->semester_id);

        $solution_details = Solution::where('status', '!=', 'Deleted')->orderBy('order_no', 'asc')->get();
        $html = view('solution.dynamic_table', compact('solution_details'))->render();
        $data = ['html' => $html];
        return response()->json($data);
    }
    public function below_order(request $request)
    {
        below_order('solutions', $request->order_no, 'semester_id', $request->semester_id);

        $solution_details = Solution::where('status', '!=', 'Deleted')->orderBy('order_no', 'asc')->get();
        $html = view('solution.dynamic_table', compact('solution_details'))->render();
        $data = ['html' => $html];
        return response()->json($data);
    }

    public function load_autocomplete_solution(request $request, $board_id, $medium_id, $standard_id, $subject_id)
    {
        //dd($request->all(),$board_id,$medium_id,$standard_id,$subject_id);
        $response=[];
        $lead_detail = Solution::where('question_type', 'like', '%' . $request['query'] . '%')
        ->where('status', '!=', 'Deleted')
        // ->where([
            // 'board_id' => isset($board_id) ? $board_id:0,
            // 'medium_id' => isset($medium_id) ? $medium_id:0,
            // 'standard_id' => isset($standard_id) ? $standard_id:0,
        //     'subject_id' => isset($subject_id) ? $subject_id:0
        // ])
        ->groupBy('question_type')
        ->get();


        if (count($lead_detail) > 0) {
            foreach ($lead_detail as $value) {
                $response[] = array("value"=>$value->question_type,"data"=>$value->question_type);
            }
        }
        return json_encode(array("suggestions" => $response));
    }

    public function addmediaView(Request $request){
        $semesterid = $request->semester_id;
        $type = $request->type;
        $media_details = Media::where(['semester_id' => $semesterid,'user_id' => Auth::user()->id,'type' => $type])->get();
        $html=view('solution.dynamic_media_model',compact('semesterid','media_details','type'))->render();
        return response()->json(['success'=>true,'html'=>$html]);
    }


    public function storeMediaView(Request $request){
        
        //dd($request->all());

        if ($request->has('file')) {
            if(count($request->file) > 0){

                for ($media=0; $media < count($request->file); $media++) { 

                    $image = $request->file[$media];//$request->file('image');
                    $url = 'upload/media/solution/';
                    $originalPath = imagePathCreate($url);
                    $name = time() . mt_rand(10000, 99999);
                    $new_name = $name . '.' . $image->getClientOriginalExtension();
                    $image->move($originalPath, $new_name);

                    $add = new Media;
                    $add->user_id = Auth::user()->id;
                    $add->semester_id = $request->semesterid;
                    $add->type = $request->hiddentype;
                    $add->image = $new_name;
                    $add->save();

                }
            }
        }

        $semesterid = $request->semesterid;
        $type = $request->hiddentype;
        $media_details = Media::where(['semester_id' => $semesterid,'user_id' => Auth::user()->id,'type' => $type])->get();
        $html=view('solution.dynamic_media_model',compact('semesterid','media_details','type'))->render();
        return response()->json(['success'=>true,'html'=>$html]);
       // dd($request->all());
    }
}

