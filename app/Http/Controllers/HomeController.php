<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Medium;
use App\Models\Standard;
use App\Models\Semester;
class HomeController extends Controller
{
    public function index(){
    	return view('dashboard');
    }
    public function get_order_data()
    {
    	$boards=Board::where('status','Active')->get();
    	if(count($boards) > 0)
    	{
    		foreach ($boards as $key => $board) {
    			$upd=Board::find($board->id);
    			$upd->order_no=$key+1;
    			$upd->save();
    		}
    	}

    	$mediums=Medium::where('status','Active')->get();
    	if(count($mediums) > 0)
    	{
    		foreach ($mediums as $key => $medium) {
    			$upd=Medium::find($medium->id);
    			$upd->order_no=$key+1;
    			$upd->save();
    		}
    	}
    	$standards=Standard::where('status','Active')->get();
    	if(count($standards) > 0)
    	{
    		foreach ($standards as $key => $standard) {
    			$upd=Standard::find($standard->id);
    			$upd->order_no=$key+1;
    			$upd->save();
    		}
    	}

    	$semesters=Semester::where('status','Active')->get();
    	if(count($semesters) > 0)
    	{
    		foreach ($semesters as $key => $semester) {
    			$upd=Semester::find($semester->id);
    			$upd->order_no=$key+1;
    			$upd->save();
    		}
    	}
    }
}
