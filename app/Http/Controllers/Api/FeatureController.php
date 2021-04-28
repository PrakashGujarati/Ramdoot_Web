<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;
use Validator;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\Unit;

class FeatureController extends Controller
{
    public function features_list(Request $request){
        
        $feature_details = Feature::where('status','Active')->get();

        if(count($feature_details) > 0){

            $data=[];
            foreach ($feature_details as $feature) {
                $image = env('APP_URL')."/upload/feature/".$feature->image;
                $data[] = ['id' => $feature->id,'title' => $feature->title,'image' => $image,"flag"=> isset($feature->flag) ? $feature->flag:"0"];
            }

            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $data,
            ]);

        }else{
            return response()->json([
                "code" => 400,
                "message" => "Features Details Not Found.",
                "data" => [],
            ]);
        }

        // [["id"=>1,"title"=>"All In One","image"=>"","flag"=>1],["id"=>2,"title"=>"Edu Video","image"=>"","flag"=>2],
        // ["id"=>3,"title"=>"Text Book","image"=>"","flag"=>3],["id"=>4,"title"=>"Solution","image"=>"","flag"=>4],
        // ["id"=>5,"title"=>"Edu Material","image"=>"","flag"=>5],["id"=>6,"title"=>"Test Paper","image"=>"","flag"=>6],
        // ["id"=>7,"title"=>"Worksheet","image"=>"","flag"=>7],
        // ["id"=>8,"title"=>"MCQ","image"=>"","flag"=>8]];
        
        
    }

    public function all_in_one(Request $request){

        $rules = array(
            'standard_id' => 'required',
            'semester_id' => 'required',
            'subject_id' => 'required',
        );
        $messages = array(
            'standard_id.required' => 'Please enter standard id.',
            'semester_id.required' => 'Please enter semester id.',
            'subject_id.required' => 'Please enter subject id.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $chkstandard = Standard::where(['id' => $request->standard_id,'status' => 'Active'])->first();
        $chksemester = Semester::where(['id' => $request->semester_id,'status' => 'Active'])->first();
        $chksuject = Subject::where(['id' => $request->subject_id,'status' => 'Active'])->first();

        if(empty($chkstandard)){
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
        elseif (empty($chksuject)) {
            return response()->json([
                "code" => 400,
                "message" => "Subject not found.",
                "data" => [],
            ]);
        }
        else{
            $totalQuestionCount=0;
            $getunit = Unit::where(['standard_id' => $request->standard_id,'semester_id' => $request->semester_id,'subject_id' => $request->subject_id,'status' => 'Active'])->orderBy('order_no','asc')->get();
            //$getdata = videos::where(['unit_id' => $request->unit_id,'status' => 'Active'])->get();
            if(count($getunit) > 0){
                $data=[];$getdata=[];
                foreach ($getunit as $value) {
                    $getdata = Feature::where(['status' => 'Active'])->get();
                    $featuredata = [];
                    foreach ($getdata as $value1) {
                        $image = env('APP_URL')."/upload/feature/".$value1->image;
                        $featuredata[] = ['id' => $value1->id,'title' => $value1->title,'image' => $image,"flag"=>$value1->flag];
                        if($value1->id == 8){
                            $totalQuestionCount = Question::where('unit_id',$value->id)->count();
                        }
                    }
                    
                    $data[] = ['id' => $value->id,'unit_title' =>$value->title,'page_no' => $value->pages,'features' => $featuredata,'sub_title'=>$value->description,'totalQuestionCount' =>$totalQuestionCount];
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
                    "message" => "Feature details not found.",
                    "data" => [],
                ]);
            }       
        }

    }
}
