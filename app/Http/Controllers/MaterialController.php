<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use App\Models\Unit;
use Auth;
use App\Models\Board;
use App\Models\QuestionType;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\Medium;
use App\Models\Standard;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:Material-view', ['only' => ['index']]);
        $this->middleware('permission:Material-add', ['only' => ['create','store']]);
        $this->middleware('permission:Material-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:Material-delete', ['only' => ['distroy']]);
    }
    public function index()
    {
        $material_details = Material::where('status', '!=', 'Deleted')->groupBy('semester_id')->get();
        return view('material.index', compact('material_details'));
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
            $material_details = Material::where(['semester_id' => $id])->where('status', '!=', 'Deleted')->orderBy('order_no', 'asc')->get();
            $question_type_details = QuestionType::where('status', '!=', 'Deleted')->get();
            $semesters_details = Semester::where('id', $id)->first();
            //$subjects_details = Subject::where('id',$id)->first();
            $isset = 1;
            return view('material.add', compact('units', 'boards', 'material_details', 'question_type_details', 'semesters_details', 'isset'));
        } else {
            $boards = Board::where('status', '!=', 'Deleted')->get();
            $units = [];
            $material_details = Material::where('status', '!=', 'Deleted')->orderBy('order_no', 'asc')->get();
            $semesters_details = [];
            $question_type_details = QuestionType::where('status', '!=', 'Deleted')->get();
            $isset = 0;
            return view('material.add', compact(
                'units',
                'boards',
                'material_details',
                'question_type_details',
                'semesters_details',
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
        $this->validate($request, [
            'unit_id'     => 'required',
            'board_id' => 'required',
            'medium_id'  => 'required',
            'standard_id' => 'required',
            'semester_id'  => 'required',
            'subject_id' => 'required',
            'question' => 'required',
            'answer' => 'required',
            'marks' => 'required'
        ]);

        /*
        if ($request->hidden_id != "0") {
            $new_name='';
            if ($request->image_file_type == 'Server') {
                if ($request->has('image')) {
                    $image = $request->file('image');
                    $url = get_subtitle($request->unit_id).'/material/thumbnail/';
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

            $add = Material::find($request->hidden_id);
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

            $msg = "Material Updated Successfully.";
        } else {*/
            $new_name='';
            if ($request->image_file_type == 'Server') {
                if ($request->has('image')) {
                    $image = $request->file('image');
                    $url = get_subtitle($request->unit_id).'/material/thumbnail/';
                    $originalPath = imagePathCreate($url);
                    $name = time() . mt_rand(10000, 99999);
                    $new_name = $name . '.' . $image->getClientOriginalExtension();
                    $image->move($originalPath, $new_name);
                }
            } else {
                $new_name = $request->image;
            }

            $last_data=Material::select('*')->where('semester_id', $request->semester_id)->orderBy('order_no', 'desc')->first();
            if ($last_data) {
                $last_no=intval($last_data->order_no)+1;
            } else {
                $last_no=1;
            }

            $add = new Material;
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

            $msg = "Material Added Successfully.";

            storeLog('material', $add->id, date('Y-m-d H:i:s'), 'create');
            storeReview('material', $add->id, date('Y-m-d H:i:s'));
        //}

        $material_details = Material::where(['semester_id' => $request->semester_id])->where('status', '!=', 'Deleted')->orderBy('order_no', 'asc')->get();
        $html = view('material.dynamic_table', compact('material_details'))->render();
        $data = ['html' => $html,'message' => $msg];
        return response()->json($data);


        //return view('.dynamic_table',compact('material_details'));
        //return redirect()->route('material.index')->with('success', 'Material Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //$units = Unit::where('status','Active')->get();

        $materialdata = Material::where('id', $request->id)->first();
        $board_sub_title = board::where(['id' => $materialdata->board_id])->first();
        $medium_sub_title = Medium::where(['id' => $materialdata->medium_id])->first();
        $standard_sub_title = Standard::where(['id' => $materialdata->standard_id])->first();
        $semester_sub_title = Semester::where(['id' => $materialdata->semester_id])->first();
        $subject_sub_title = Subject::where(['id' => $materialdata->subject_id])->first();
        $unit_sub_title = Unit::where(['id' => $materialdata->unit_id])->first();
        $sub_title = ['board_sub_title' => $board_sub_title,'medium_sub_title' => $medium_sub_title,
        'standard_sub_title' => $standard_sub_title,'semester_sub_title' => $semester_sub_title,
        'subject_sub_title' => $subject_sub_title,'unit_sub_title' => $unit_sub_title];
        $data = ['materialdata' => $materialdata,'sub_title' => $sub_title];
        return $data;
        //return $materialdata;
        //$boards = Board::where('status','Active')->get();
        //$question_type_details = QuestionType::where('status','Active')->get();
        //return view('material.edit',compact('materialdata','units','boards','question_type_details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material, $id)
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
            $location = public_path('upload/material/thumbnail/').$new_name;

            $file_extension = pathinfo($location, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);

            if (in_array($file_extension, $valid_ext)) {
                $this->compressImage($image->getPathName(), $location, 60);
            }
        } else {
            $new_name = $request->hidden_image;
        }

        $update = Material::find($id);
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

        return redirect()->route('material.index')->with('success', 'Material Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\material  $material
     * @return \Illuminate\Http\Response
     */
    public function distroy(Request $request)
    {
        if ($request->has('status')) {
            if ($request->status == "Active") {
                $delete = Material::find($request->id);
                $delete->status = "Inactive";
                $delete->save();
            } else {
                $delete = Material::find($request->id);
                $delete->status = "Active";
                $delete->save();
            }
        } else {
            $delete = Material::find($request->id);
            $delete->status = "Deleted";
            $delete->save();

            delete_order('materials', $request->id, 1);
        }

        $material_details = Material::where(['semester_id' => $request->semester_id])->where('status', '!=', 'Deleted')->orderBy('order_no', 'asc')->get();
        return view('material.dynamic_table', compact('material_details'));
        //return redirect()->route('material.index')->with('success', 'Material Deleted Successfully.');
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
        above_order('materials', $request->order_no, 'semester_id', $request->semester_id);

        $material_details = Material::where('status', '!=', 'Deleted')->orderBy('order_no', 'asc')->get();
        $html = view('material.dynamic_table', compact('material_details'))->render();
        $data = ['html' => $html];
        return response()->json($data);
    }
    public function below_order(request $request)
    {
        below_order('materials', $request->order_no, 'semester_id', $request->semester_id);

        $material_details = Material::where('status', '!=', 'Deleted')->orderBy('order_no', 'asc')->get();
        $html = view('material.dynamic_table', compact('material_details'))->render();
        $data = ['html' => $html];
        return response()->json($data);
    }

    public function load_autocomplete_material(request $request, $board_id, $medium_id, $standard_id, $subject_id)
    {
        // dd($request->all(), $board_id, $medium_id, $standard_id, $subject_id);
        $response=[];

        // return isset($subject_id);

        $lead_detail = Material::
        where('question_type', 'like', '%' . $request['query'] . '%')
        ->where('status', '!=', 'Deleted')
        // ->where([
        //     'board_id' => isset($board_id) ? $board_id: 0,
        //     'medium_id' => isset($medium_id) ? $medium_id : 0,
        //     'standard_id' => isset($standard_id) ? $standard_id:0,
        //     'subject_id' => isset($subject_id) ? $subject_id : 0
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
}
