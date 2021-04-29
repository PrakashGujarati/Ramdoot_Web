<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\Unit;
use DB;
use Validator;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\Semester;
use App\Models\QuestionType;

class MaterialController extends Controller
{

    public function materialList(Request $request){

        $rules = array(
            'unit_id' => 'required'
        );
        $messages = array(
            'unit_id.required' => 'Please enter unit id.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }


        $chkunit = Unit::where(['id' => $request->unit_id,'status' => 'Active'])->first();

        if(empty($chkunit)){
            return response()->json([
                "code" => 400,
                "message" => "Unit not found.",
                "data" => [],
            ]);
        }
        else{

            $getdata = Material::where(['unit_id' => $request->unit_id,'status' => 'Active'])
            ->groupBy('question_type')->get();

            if($getdata->count() > 0){

                $data=[];
                foreach ($getdata as $value1) {

                    $title = $value1->label;

                    $getdata_material = Material::where(['question_type' => $value1->question_type,
                            'status' => 'Active'])->orderBy('order_no','asc')->get();
                    $materialdata=[];
                    foreach ($getdata_material as $value_sub) {

                        $image = $value_sub->image;
                        $materialdata[] = ['id' => $value_sub->id,'question' => $value_sub->question,'sub_title'=>$value->sub_title,'answer' => $value_sub->answer,'marks' => $value_sub->marks,'image' => $image,'label' => $value_sub->label];
                    }    

                    $getquestion_type_details = QuestionType::where(['id' => $value1->question_type])->first();
                    $data[] = ['question_type' => $getquestion_type_details->question_type,'material' => $materialdata];
                }

                // $sub_title = Unit::where(['id' => $request->unit_id,'status' => 'Active'])->first();
                // if($sub_title)
                // {
                //     $sub_title=$sub_title->description;
                // }
                // else
                // {
                //     $sub_title="";
                // }                  
                return response()->json([
                    "code" => 200,
                    "message" => "success",
                    "data" => $data,
                ]);
            }
            else{
                return response()->json([
                    "code" => 400,
                    "message" => "Material details not found.",
                    "data" => [],
                ]);
            }       
        }

    }

    
}
