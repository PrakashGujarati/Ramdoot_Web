<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDataLog;
use App\Models\UserDataReview;

class LogController extends Controller
{
    public function index()
    {
    	return view('log.index');
    }
    public function getData(request $request)
    {
    	$getData=UserDataLog::with('user')->whereDate('upload_time','>=',$request->start_date)->whereDate('upload_time','<=',$request->end_date)->get();
    	$html=view('log.dyanamicTable',compact('getData'))->render();
    	return response()->json(['html'=>$html]);
    }	
}
