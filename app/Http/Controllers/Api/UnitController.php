<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\Board;
use App\Models\Unit;
use App\Models\Standard;
use App\Models\Subject;
use DB;
use Validator;
use App\Models\Book;
use App\Models\Note;
use App\Models\Paper;
use App\Models\Worksheet;
use App\Models\Question;
use App\Models\Feature;
use App\Models\Videos;
use App\Models\Material;
use App\Models\Solution;
use App\Models\pdf_view;

class UnitController extends Controller
{
    public function unitList(Request $request){
        $rules = array(
            //'standard_id' => 'required',
            'semester_id' => 'required',
            'subject_id' => 'required',
            'feature_id' => 'required'
        );
        $messages = array(
            //'standard_id.required' => 'Please enter standard id.',
            'semester_id.required' => 'Please enter semester id.',
            'subject_id.required' => 'Please enter subject id.',
            'feature_id.required' => 'Please enter feature id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                $msg = $validator->messages();
                return ['status' => "false",'msg' => $msg];
            }

           // $chkstandard = Standard::where(['id' => $request->standard_id,'status' => 'Active'])->first();
            //$chksemester = Semester::where(['id' => $request->semester_id,'status' => 'Active'])->first();
            $chksubject = subject::where(['id' => $request->subject_id,'status' => 'Active'])->first();

            // if (empty($chkstandard)) {
            //     return response()->json([
            //         "code" => 400,
            //         "message" => "Standard not found.",
            //         "data" => [],
            //     ]);
            // }
            if (empty($chksubject)) {
                return response()->json([
                    "code" => 400,
                    "message" => "subject not found.",
                    "data" => [],
                ]);
            }
            else{
                if($request->semester_id==0)
                {   
                    $getdata = Unit::where(['subject_id' => $request->subject_id,'status' => 'Active'])->orderBy('order_no','asc')->get();
                }else
                {
                    $getdata = Unit::where(['subject_id' => $request->subject_id,'semester_id' => $request->semester_id,'status' => 'Active'])->orderBy('order_no','asc')->get();
                }
                
                if(count($getdata) > 0){
                    $data=[];$totalcount=0;
                    foreach ($getdata as $value) {
                        $readcount=0;
                        $url = $value->url;
                        $thumbnail = $value->thumbnail;

                        if($request->feature_id != 0){

                            if($request->feature_id == 3){
                                $totalcount = Book::where('unit_id',$value->id)->count();
                                $books = Book::where('unit_id',$value->id)->orderBy('order_no','asc')->get();
                                foreach($books as $book)
                                {
                                    $c = pdf_view::where(['type' => 'Textbook','type_id' => $book->id])->count();
                                    if($c)
                                    {
                                        $readcount++;
                                    }
                                }
                            }
                            elseif ($request->feature_id == 9) {
                                $totalcount = Note::where('unit_id',$value->id)->count();
                                $notes = Note::where('unit_id',$value->id)->orderBy('order_no','asc')->get();
                                foreach($notes as $note)
                                {
                                    $c = pdf_view::where(['type' => 'Note','type_id' => $note->id])->count();
                                    if($c)
                                    {
                                        $readcount++;
                                    }
                                }
                            }
                            elseif ($request->feature_id == 7) {
                                $totalcount = Worksheet::where('unit_id',$value->id)->count();
                                $worksheets = Worksheet::where('unit_id',$value->id)->orderBy('order_no','asc')->get();
                                foreach($worksheets as $worksheet)
                                {
                                    $c = pdf_view::where(['type' => 'Worksheet','type_id' => $worksheet->id])->count();
                                    if($c)
                                    {
                                        $readcount++;
                                    }
                                }
                            }
                            elseif ($request->feature_id == 6) {
                                $totalcount = Paper::where('unit_id',$value->id)->count();
                                $papers = Paper::where('unit_id',$value->id)->orderBy('order_no','asc')->get();
                                foreach($papers as $paper)
                                {
                                    $c = pdf_view::where(['type' => 'Paper','type_id' => $paper->id])->count();
                                    if($c)
                                    {
                                        $readcount++;
                                    }
                                }
                            }
                            elseif ($request->feature_id == 2){
                                $totalcount = Videos::where('unit_id',$value->id)->count();
                                $videos = Videos::where('unit_id',$value->id)->orderBy('order_no','asc')->get();
                                foreach($videos as $video)
                                {
                                    $c = pdf_view::where(['type' => 'Video','type_id' => $video->id])->count();
                                    if($c)
                                    {
                                        $readcount++;
                                    }
                                }   
                            }
                            elseif ($request->feature_id == 5){
                                
                                $totalcount = Material::where('unit_id',$value->id)->count();
                                $materials = Material::where('unit_id',$value->id)->orderBy('order_no','asc')->get();
                                foreach($materials as $material)
                                {
                                    $c = pdf_view::where(['type' => 'Material','type_id' => $material->id])->count();
                                    if($c)
                                    {
                                        $readcount++;
                                    }
                                }   
                            }
                            elseif($request->feature_id == 8){
                                $totalcount = Question::where('unit_id',$value->id)->count();
                                $Questions = Question::where('unit_id',$value->id)->get();
                                foreach($Questions as $Question)
                                {
                                    $c = pdf_view::where(['type' => 'MCQ','type_id' => $Question->id])->count();
                                    if($c)
                                    {
                                        $readcount++;
                                    }
                                }
                            }
                            elseif($request->feature_id == 4){
                                $totalcount = Solution::where('unit_id',$value->id)->count();
                                $solutions = Solution::where('unit_id',$value->id)->orderBy('order_no','asc')->get();
                                foreach($solutions as $solution)
                                {
                                    $c = pdf_view::where(['type' => 'Solution','type_id' => $solution->id])->count();
                                    if($c)
                                    {
                                        $readcount++;
                                    }
                                }
                            }
                        }

                        $unitcount = Question::where('unit_id',$value->id)->count();
                        $data[] = ['id' => $value->id,'title' => $value->title,'sub_title'=>$value->sub_title,'description' => $value->description,'url' => $url,'thumbnail' => $thumbnail,"pages"=> $value->pages,"total_questions"=>$unitcount,"total_count"=>$totalcount,"readcount"=>$readcount];
                    }

                    return response()->json([
                        "code" => 200,
                        "message" => "success",
                        "data" => $data,
                    ]);
                }
                else{
                    return response()->json([
                        "code" => 400,
                        "message" => "Subject details not found.",
                        "data" => [],
                    ]);
                }	
            }
    }
}

