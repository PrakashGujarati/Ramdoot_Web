<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\material;
use App\Models\unit;
use DB;
use Validator;
use App\Models\Standard;
use App\Models\Subject;
use App\Models\semester;

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


        $chkunit = unit::where(['id' => $request->unit_id,'status' => 'Active'])->first();

        if(empty($chkunit)){
            return response()->json([
                "code" => 400,
                "message" => "Unit not found.",
                "data" => [],
            ]);
        }
        else{

            $getdata = material::where(['unit_id' => $request->unit_id,'status' => 'Active'])->get();

            if($getdata->count() > 0){

                $data=[];$materialdata=[];
                foreach ($getdata as $value1) {
                    $title = $value1->label;
                    $materialdata[] = ['id' => $value1->id,'title' => $value1->title,'url' => $value1->url,'size' => $value1->size,'description' => $value1->description,'label' => $value1->label];
                }

                $data[] = ['id' => $request->unit_id,'unit_title' => isset($chkunit->title) ? $chkunit->title:'','material' => $materialdata];
                
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
