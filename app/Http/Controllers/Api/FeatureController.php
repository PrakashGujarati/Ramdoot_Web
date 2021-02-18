<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function features_list(Request $request){
        
        $data = [["id"=>1,"title"=>"All In One","image"=>"","flag"=>1],["id"=>2,"title"=>"Edu Video","image"=>"","flag"=>2],
        ["id"=>3,"title"=>"Text Book","image"=>"","flag"=>3],["id"=>4,"title"=>"Solution","image"=>"","flag"=>4],
        ["id"=>5,"title"=>"Edu Material","image"=>"","flag"=>5],["id"=>6,"title"=>"Test Paper","image"=>"","flag"=>6],
        ["id"=>7,"title"=>"Worksheet","image"=>"","flag"=>7],
        ["id"=>8,"title"=>"MCQ","image"=>"","flag"=>8]];
        
        return response()->json([
            "code" => 200,
            "message" => "success",
            "data" => $data,
        ]);
    }
}