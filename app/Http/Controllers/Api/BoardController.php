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

    	$getboard_details = Board::where(['status' => 'Active'])->select('id','name','thumbnail','thumbnail_file_type')->groupBy('name')->get();

    	if(count($getboard_details) > 0){
    		$data=[];$getdata=[];
            $mediumArray = [];
    		foreach ($getboard_details as $value) { 
    			$getdata = Medium::select('id','medium_name')->where('board_id',$value->id)->orderBy('order_no','asc')->get();
                $sortname = explode("-",$value->name);
                $mediumArray=[];
                foreach ($getdata as $key => $sub_value) 
                {
                    $mediumSortName = explode(" ",$sub_value->medium_name);
                    $first = substr($mediumSortName[0], 0,1);
                    $last = substr(isset($mediumSortName[1]) ? $mediumSortName[1]:'', 0,1);
                    $mediumArray[] = ['id' => $sub_value->id,'medium_name' => $sub_value->medium_name,'sub_title' => $sub_value->sub_title,'sort_name' => $first.$last];
                }
                $thumbnail='';
                if($value->thumbnail){
                	if($value->thumbnail_file_type == "Server"){
                		$thumbnail =  env('APP_URL')."/upload/board/thumbnail/".$value->thumbnail;		
                	}
                	else{
                		$thumbnail =  $value->thumbnail;	
                	}
                	
                }
    			$data[] = ['id' => $value->id,'board_name' => $value->name,'sub_title' => $value->sub_title,'sort_name' => trim($sortname[0]),'abbreviation' => $value->abbreviation,'url' => $value->url,'thumbnail' => $thumbnail,'medium' => $mediumArray];
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
