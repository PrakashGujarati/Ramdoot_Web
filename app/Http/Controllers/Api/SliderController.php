<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;

class SliderController extends Controller
{
    public function slider(){
    	$getdata = Slider::where(['status' => 'Active'])->orderBy('order', 'ASC')->get();

    	if(count($getdata) > 0){
    		$data=[];
    		foreach ($getdata as $value) {
    			$image = $value->image;
    			$data[] = ['id' => $value->id,'title' => $value->area,'short_desc' => $value->text,'image' => $image,'url' => $value->url];
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
			  	"message" => "Slider details not found.",
			  	"data" => [],
	        ]);
    	}

    }
}
