<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Medium;
use DB;

class BoardController extends Controller
{
    public function boardMedium(Request $request){


    	$getboard_details = Board::where(['status' => 'Active'])->select('id','name')->groupBy('name')->get();

    	if(count($getboard_details) > 0){
    		$data=[];$getdata=[];
    		foreach ($getboard_details as $value) {
    			$getdata = Medium::select('id','medium_name')->where('board_id',$value->id)->get();
    			$data[] = ['id' => $value->id,'board_name' => $value->name,'medium' => $getdata];
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
			  	"message" => "Baord details not found.",
			  	"data" => [],
	        ]);
    	}

    }
}
