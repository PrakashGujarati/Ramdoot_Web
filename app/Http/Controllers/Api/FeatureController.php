<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\feature;

class FeatureController extends Controller
{
    public function features_list(Request $request){
        
        $feature_details = feature::where('status','Active')->get();

        if(count($feature_details) > 0){

            $data=[];
            foreach ($feature_details as $feature) {
                $image = env('APP_URL')."/upload/feature/".$feature->image;
                $data[] = ['id' => $feature->id,'title' => $feature->title,'image' => $image,"flag"=>$feature->flag];
            }

            return response()->json([
                "code" => 200,
                "message" => "success",
                "data" => $data,
            ]);

        }else{
            return response()->json([
                "code" => 200,
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
}
