<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDataReview;

class UserDataReviewController extends Controller
{
    public function index()
    {
    	return view('reviews.index');
    }
    public function user_ajax_review(request $request)
    {
    	$getData=UserDataReview::with('user')->whereDate('review_time','>=',$request->start_date)->whereDate('review_time','<=',$request->end_date)->get();
    	$html=view('reviews.dyanamicTable',compact('getData'))->render();
    	return response()->json(['html'=>$html]);
    }
    public function accept_review($id)
    {
    	$updData=UserDataReview::find($id);
    	$updData->status="Accept";
    	$updData->save();
    	return redirect()->back();
    }
    public function reject_review($id)
    {
    	$updData=UserDataReview::find($id);
    	$updData->status="Reject";
    	$updData->save();
    	return redirect()->back();
    }
}
