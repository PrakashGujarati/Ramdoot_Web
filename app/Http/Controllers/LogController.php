<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserDataLog;
use App\Models\UserDataReview;

class LogController extends Controller
{
    public function index()
    {
        $users = User::all();
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d');
        return view('log.index', ['users'=>$users,'start_date'=>$start_date,'end_date'=>$end_date]);
    }
    public function getData(request $request)
    {
        $getData=UserDataLog::with('user')
        ->whereDate('upload_time', '>=', $request->start_date)
        ->whereDate('upload_time', '<=', $request->end_date)
        ->where(['user_id' => $request->user_id])
        ->orderBy('upload_time', 'desc')
        ->get();
        $role = Role::where('id', $getData[0]->user->role_id)->first() ;
        $html=view('log.dyanamicTable', ['getData' => $getData,'role' => $role])->render();
        return response()->json(['html'=>$html]);
    }
    public function logMinutes(Request $request)
    {
        foreach ($request->log_ids as $key => $id) {
            UserDataLog::where('id', $id)->update([
                'minutes' => $request->minutes[$key]
            ]);
        }
        return view('log.index', ['users'=>User::all(),'start_date'=> $request->start_date,'end_date'=>$request->start_date,'user_id'=>$request->user_id]);
    }
}
