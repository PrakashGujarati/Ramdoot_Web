<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\question;
use Validator;

class McqController extends Controller
{
    public function mcqPractice(Request $request){

    	$rules = array(
            'unit_id' => 'required',
            'no_of_question' => 'required',
        );
        $messages = array(
        	'unit_id.required' => 'Please enter unit id.',
            'no_of_question.required' => 'Please enter number of question.',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $msg = $validator->messages();
            return ['status' => "false",'msg' => $msg];
        }

        $get_question = question::where(['unit_id' => $request->unit_id])->inRandomOrder()->limit($request->no_of_question)->get();


        $data=[];
        if(count($get_question) > 0){
        	foreach ($get_question as $key => $value) {

        		$is_true_a=0;$is_true_b=0;$is_true_c=0;$is_true_d=0;
        		if($value->answer == "A"){
        			$is_true_a=1; 
        		}elseif($value->answer == "B"){
        			$is_true_b=1;
        		}elseif($value->answer == "C"){
        			$is_true_c=1;
        		}elseif($value->answer == "D"){
        			$is_true_d=1;
        		}

        		$data[] = ['id' => $value->id,'question' => $value->question,'answer' => $value->answer,'options' => [['option_a' => $value->option_a,'is_true' => $is_true_a],['option_b' => $value->option_b,'is_true' => $is_true_b],['option_c' => $value->option_c,'is_true' => $is_true_c],['option_d' => $value->option_d,'is_true' => $is_true_d]]];
        	}

        	return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $data,
            ]);

        }else{
        	return response()->json([
                "code" => 400,
                "message" => "MCQ not found.",
                "data" => [],
            ]);
        }
    }
}
