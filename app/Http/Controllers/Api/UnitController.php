<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\semester;
use App\Models\Board;
use App\Models\unit;
use App\Models\Standard;
use App\Models\Subject;
use DB;
use Validator;

class UnitController extends Controller
{
    public function unitList(Request $request){
        $rules = array(
            'standard_id' => 'required',
            'semester_id' => 'required',
            'subject_id' => 'required',
        );
        $messages = array(
            'standard_id.required' => 'Please enter standard id.',
            'semester_id.required' => 'Please enter semester id.',
            'subject_id.required' => 'Please enter subject id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                $msg = $validator->messages();
                return ['status' => "false",'msg' => $msg];
            }

            $chkstandard = Standard::where(['id' => $request->standard_id,'status' => 'Active'])->first();
            $chksemester = semester::where(['id' => $request->semester_id,'status' => 'Active'])->first();
            $chksubject = subject::where(['id' => $request->subject_id,'status' => 'Active'])->first();

            if (empty($chkstandard)) {
                return response()->json([
                    "code" => 400,
                    "message" => "Standard not found.",
                    "data" => [],
                ]);
            }
            elseif (empty($chksemester)) {
                return response()->json([
                    "code" => 400,
                    "message" => "Semester not found.",
                    "data" => [],
                ]);
            }
            elseif (empty($chksubject)) {
                return response()->json([
                    "code" => 400,
                    "message" => "subject not found.",
                    "data" => [],
                ]);
            }
            else{
                $getdata = unit::where(['subject_id' => $request->subject_id,'standard_id' => $request->standard_id,'semester_id' => $request->semester_id,'status' => 'Active'])->get();
                
                if(count($getdata) > 0){
                    $data=[];
                    foreach ($getdata as $value) {
                        $url = env('APP_URL')."/upload/subject/url/".$value->url;
                        $thumbnail = env('APP_URL')."/upload/subject/thumbnail/".$value->thumbnail;
                        $data[] = ['id' => $value->id,'title' => $value->title,'sub_title' => $value->description,'url' => $url,'thumbnail' => $thumbnail,"pages"=> $value->pages];
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

